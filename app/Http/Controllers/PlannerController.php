<?php

namespace App\Http\Controllers;

use App\Models\ExamRoutine;
use App\Models\SectionRoutine;
use App\Models\UserExamRoutine;
use App\Models\UserSectionRoutine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class PlannerController extends Controller
{
    public function course() {
        $allCourses = ExamRoutine::all();
        $userRoutines = collect([]);
        if (Auth::check()) {
            $userRoutines = Auth::user()->userExamRoutines()->with('examRoutine')->get()->pluck('examRoutine');
        }
        
        return view('coursePlanner', [
            'allCourses' => $allCourses,
            'userRoutines' => $userRoutines
        ]);
    }

    public function section() {
        $sections = SectionRoutine::all();
        $userRoutines = collect([]);
        if (Auth::check()) {
            $userRoutines = Auth::user()->userSectionRoutines()->with('sectionRoutine')->get()->pluck('sectionRoutine');
        }
        
        return view('sectionPlanner', [
            'sections' => $sections,
            'userRoutines' => $userRoutines
        ]);
    }

    public function saveCourseRoutine(Request $request) {
        $routines = $request->input('routines', []);
        
        // Only validate non-empty routines
        if (!empty($routines)) {
            $request->validate([
                'routines' => 'array',
                'routines.*' => 'integer|exists:exam_routines,id'
            ]);
        }

        $user = Auth::user();
        $user->userExamRoutines()->delete(); // Clear existing

        foreach ($routines as $routineId) {
            UserExamRoutine::create([
                'user_id' => $user->id,
                'exam_routine_id' => $routineId
            ]);
        }

        return response()->json(['message' => 'Course routine saved successfully']);
    }

    public function saveSectionRoutine(Request $request) {
        $routines = $request->input('routines', []);
        
        // Only validate non-empty routines
        if (!empty($routines)) {
            $request->validate([
                'routines' => 'array',
                'routines.*' => 'integer|exists:section_routines,id'
            ]);
        }

        $user = Auth::user();
        $user->userSectionRoutines()->delete(); // Clear existing

        foreach ($routines as $routineId) {
            UserSectionRoutine::create([
                'user_id' => $user->id,
                'section_routine_id' => $routineId
            ]);
        }

        return response()->json(['message' => 'Section routine saved successfully']);
    }
}