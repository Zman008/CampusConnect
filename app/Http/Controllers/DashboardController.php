<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ১. টাস্কগুলো আনা
        $pendingTasks = Task::where('user_id', $userId)->where('is_completed', false)->latest()->get();
        $completedTasks = Task::where('user_id', $userId)->where('is_completed', true)->latest()->get();

        // ২. ওয়েদার ডাটা (ডিজাইন ঠিক রাখার জন্য আপাতত ফিক্সড ডাটা)
        $weather = [
            'temp' => 28,
            'desc' => 'Sunny',
            'icon' => 'Clear'
        ];

        // ৩. আপকামিং এক্সাম (আপাতত খালি রাখা হয়েছে)
        $upcomingExam = null; 

        return view('dashboard', compact('pendingTasks', 'completedTasks', 'weather', 'upcomingExam'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|max:255']);
        
        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'is_completed' => false,
        ]);
        
        return back();
    }

    public function toggle(Task $task)
    {
        // নিরাপত্তা চেক: নিজের টাস্ক কি না
        if ($task->user_id !== Auth::id()) { abort(403); }

        $task->is_completed = !$task->is_completed;
        $task->save();
        return back();
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) { abort(403); }
        $task->delete();
        return back();
    }
}