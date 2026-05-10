<?php

namespace App\Http\Controllers;

use App\Models\CommunityGroup;
use App\Models\CommunityMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        if ($blockedResponse = $this->blockBannedUser()) {
            return $blockedResponse;
        }

        $groups = CommunityGroup::all();
        return view('community', compact('groups'));
    }

    public function showGroup($groupId)
    {
        if ($blockedResponse = $this->blockBannedUser()) {
            return $blockedResponse;
        }

        $group = CommunityGroup::findOrFail($groupId);
        $groups = CommunityGroup::withCount('messages')->orderBy('name')->get();
        $messages = $group->messages()->with('user')->orderBy('created_at', 'asc')->get();
        
        return view('group-chat', compact('group', 'groups', 'messages'));
    }

    public function sendMessage(Request $request, $groupId)
    {
        try {
            if ($blockedResponse = $this->blockBannedUser($request)) {
                return $blockedResponse;
            }

            $validated = $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $group = CommunityGroup::findOrFail($groupId);
            
            $message = CommunityMessage::create([
                'group_id' => $groupId,
                'user_id' => Auth::id(),
                'message' => $validated['message'],
            ]);

            $message->load('user');

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
        if ($blockedResponse = $this->blockBannedUser($request)) {
            return $blockedResponse;
        }

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

    public function reportMessage(Request $request, $groupId, CommunityMessage $message)
    {
        if ($blockedResponse = $this->blockBannedUser($request)) {
            return $blockedResponse;
        }

        CommunityGroup::findOrFail($groupId);
        abort_unless((int) $message->group_id === (int) $groupId, 404);

        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $message->update([
            'reported_at' => now(),
            'reported_by_user_id' => Auth::id(),
            'report_reason' => $validated['reason'] ?? 'Reported from community chat',
        ]);

        return back()->with('success', 'Message reported to admin.');
    }

    private function blockBannedUser(?Request $request = null)
    {
        if (! Auth::user()?->banned_at) {
            return null;
        }

        if ($request?->expectsJson()) {
            return response()->json([
                'success' => false,
                'error' => 'You cannot access the community page.',
            ], 403);
        }

        return redirect()
            ->route('dashboard')
            ->with('community_blocked', 'You cannot access the community page.');
    }
}
