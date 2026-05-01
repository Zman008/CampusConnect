<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the main workspace dashboard.
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Fetch pending and completed tasks for the authenticated user
        $pendingTasks = Task::where('user_id', $userId)->where('is_completed', false)->latest()->get();
        $completedTasks = Task::where('user_id', $userId)->where('is_completed', true)->latest()->get();

        // 2. Dummy weather data for UI consistency
        $weather = [
            'temp' => 28,
            'desc' => 'Sunny',
            'icon' => 'Clear'
        ];

        // 3. Placeholder for upcoming exams
        $upcomingExam = null; 

        return view('dashboard', compact('pendingTasks', 'completedTasks', 'weather', 'upcomingExam'));
    }

    /**
     * Show the CGPA Calculator page.
     */
    public function cgpaCalculator()
    {
        return view('calculator.cgpa');
    }

    /**
     * Store a new task in the database.
     */
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

    /**
     * Toggle the completion status of a task.
     */
    public function toggle(Task $task)
    {
        // Security Check: Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) { 
            abort(403); 
        }

        $task->is_completed = !$task->is_completed;
        $task->save();
        return back();
    }

    /**
     * Remove a task from the database.
     */
    public function destroy(Task $task)
    {
        // Security Check: Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) { 
            abort(403); 
        }
        
        $task->delete();
        return back();
    }
}