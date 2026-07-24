<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ClassLink; // Essential model for handling university class links
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the main workspace dashboard.
     * 
     * This method fetches user-specific tasks, filters them by status,
     * and passes dynamic data like weather and upcoming exams to the view.
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Fetching pending and completed tasks separately for the Task Manager UI
        $pendingTasks = Task::where('user_id', $userId)
            ->where('is_completed', false)
            ->latest()
            ->get();

        $completedTasks = Task::where('user_id', $userId)
            ->where('is_completed', true)
            ->latest()
            ->get();

        // 2. Mock weather data structure for the Dashboard header widget
        $weather = [
            'temp' => 28,
            'desc' => 'Sunny',
            'icon' => 'Clear'
        ];

        // 3. Placeholder variable for future examination routine integration
        $upcomingExam = null; 

        return view('dashboard', compact('pendingTasks', 'completedTasks', 'weather', 'upcomingExam'));
    }

    /**
     * Show the Class Links & Recordings hub.
     * 
     * Renders a list of prototype courses and retrieves student-submitted
     * links from the database to be displayed in the section selection modals.
     */
    public function classLinks()
    {
        // Static array representing the prototype course list for the UIU CSE Dept
        $courses = [
            ['id' => 'MATH 1151', 'name' => 'Fundamental Calculus', 'playlist' => 'https://www.youtube.com/playlist?list=PL3_ATDyQLqPgSXzY50bxmyipW0ob2UThn'],
            ['id' => 'CSE 1325', 'name' => 'Digital Logic Design', 'playlist' => 'https://www.youtube.com/playlist?list=PL3_ATDyQLqPhZFbjQa36MqE5MLLUjGYc3'],
            ['id' => 'CSE 4509', 'name' => 'Operating Systems', 'playlist' => 'https://www.youtube.com/playlist?list=PL3_ATDyQLqPiuxm-GjBI8lXFp9M19v-lD'],
            ['id' => 'CSE 3421', 'name' => 'Software Engineering', 'playlist' => 'https://www.youtube.com/playlist?list=PL3_ATDyQLqPgepsuDv5zQX97CTQWu5_Rr'],
            ['id' => 'CSE 3411', 'name' => 'System Analysis and Design', 'playlist' => 'https://www.youtube.com/playlist?list=PL3_ATDyQLqPi8dfAhsyq2KQxcPECqHeRg'],
        ];

        // Fetching all class links from the DB to support the A-Z Section selection logic
        $dbLinks = ClassLink::all();

        return view('academic-hub.class_links', compact('courses', 'dbLinks'));
    }

    /**
     * Handle the submission of new Class Links.
     * 
     * Validates input data from students or teachers and saves it 
     * to the 'class_links' table for administrative review.
     */
    public function storeClassLink(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string',
            'section'     => 'required|string|max:2', // Supports sections like A, B, L1, etc.
            'link_type'   => 'required|in:live,recording',
            'url'         => 'required|url',
        ]);

        ClassLink::create([
            'course_code' => $request->course_code,
            'section'     => strtoupper($request->section),
            'link_type'   => $request->link_type,
            'url'         => $request->url,
            'added_by'    => Auth::id(),
        ]);

        return back()->with('success', '✅ Class link has been submitted successfully!');
    }

    /**
     * Show the interactive CGPA Calculator page.
     */
    public function cgpaCalculator()
    {
        return view('calculator.cgpa');
    }

    /**
     * Show the Tuition Fee Calculator page designed for the CSE Department.
     */
    public function tuitionCalculator()
    {
        return view('calculator.tuition');
    }

    /**
     * Store a new task/mission in the database.
     * 
     * Includes support for optional descriptions and deadlines.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
        ]);
        
        Task::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'is_completed' => false,
        ]);
        
        return back();
    }

    /**
     * Toggle the completion status (Pending/Completed) of a mission.
     */
    public function toggle(Task $task)
    {
        // Security check to ensure users only modify their own tasks
        if ($task->user_id !== Auth::id()) { 
            abort(403, 'Unauthorized action.'); 
        }

        $task->is_completed = !$task->is_completed;
        $task->save();

        return back();
    }

    /**
     * Permanently remove a task mission from the database.
     */
    public function destroy(Task $task)
    {
        // Security check to prevent unauthorized deletion
        if ($task->user_id !== Auth::id()) { 
            abort(403, 'Unauthorized action.'); 
        }
        
        $task->delete();

        return back();
    }
}