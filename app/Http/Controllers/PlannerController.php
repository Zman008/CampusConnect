<?php

namespace App\Http\Controllers;

use App\Models\ExamRoutine;
use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function index() {
        $allCourses = ExamRoutine::all();
        
        return view('coursePlanner', [
            'allCourses' => $allCourses
        ]);
    }
}