<?php

namespace App\Http\Controllers;

use App\Models\CommunityGroup;
use App\Models\CommunityMessage;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $groups = CommunityGroup::all();
        return view('community', compact('groups'));
    }

    public function showGroup($groupId)
    {
        $group = CommunityGroup::findOrFail($groupId);
        $groups = CommunityGroup::withCount('messages')->orderBy('name')->get();
        $messages = $group->messages()->with('user')->orderBy('created_at', 'asc')->get();
        
        return view('group-chat', compact('group', 'groups', 'messages'));
    }

    public function sendMessage(Request $request, $groupId)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $group = CommunityGroup::findOrFail($groupId);
            
            $message = CommunityMessage::create([
                'group_id' => $groupId,
                'user_id' => Auth::id(),
                'message' => $validated['message'],
            ]);

            // Load the user relationship
            $message->load('user');

            // Broadcast the message
            broadcast(new MessageSent($message))->toOthers();

            if (! $request->expectsJson()) {
                return redirect()
                    ->route('community.group', $groupId)
                    ->with('success', 'Message sent.');
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (! $request->expectsJson()) {
                return back()
                    ->withErrors($e->errors())
                    ->withInput();
            }

            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMessages(Request $request, $groupId)
    {
        $group = CommunityGroup::findOrFail($groupId);
        $messages = $group->messages()
            ->with('user')
            ->when($request->filled('after_id'), function ($query) use ($request) {
                $query->where('id', '>', (int) $request->input('after_id'));
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
        ]);
    }
}
