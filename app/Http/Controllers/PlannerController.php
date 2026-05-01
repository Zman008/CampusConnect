<?php

namespace App\Http\Controllers;

use App\Models\ExamRoutine;
use App\Models\SectionRoutine;
use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function course() {
        $allCourses = ExamRoutine::all();
        
        return view('coursePlanner', [
            'allCourses' => $allCourses
        ]);
    }

    public function section() {
        $sections = SectionRoutine::all();
        
        return view('sectionPlanner', [
            'sections' => $sections
        ]);
    }
}