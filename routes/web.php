<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\AcademicCalendarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\QuestionBankController;
use Illuminate\Support\Facades\Route;

// 1. Guest Routes
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Admin Panel
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/admin/groups', [AdminController::class, 'storeGroup'])->name('admin.groups.store');
Route::delete('/admin/groups/{group}', [AdminController::class, 'deleteGroup'])->name('admin.groups.delete');
Route::post('/admin/exam-routines', [AdminController::class, 'storeExamRoutine'])->name('admin.exam-routines.store');
Route::patch('/admin/exam-routines/{examRoutine}', [AdminController::class, 'updateExamRoutine'])->name('admin.exam-routines.update');
Route::delete('/admin/exam-routines/{examRoutine}', [AdminController::class, 'deleteExamRoutine'])->name('admin.exam-routines.delete');
Route::post('/admin/section-routines', [AdminController::class, 'storeSectionRoutine'])->name('admin.section-routines.store');
Route::patch('/admin/section-routines/{sectionRoutine}', [AdminController::class, 'updateSectionRoutine'])->name('admin.section-routines.update');
Route::delete('/admin/section-routines/{sectionRoutine}', [AdminController::class, 'deleteSectionRoutine'])->name('admin.section-routines.delete');
Route::patch('/admin/users/{user}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');
Route::patch('/admin/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('admin.users.unban');

// Question Bank Admin Routes
Route::delete('/admin/question-bank/{file}', [AdminController::class, 'deleteQuestionBankFile'])->name('admin.questionbank.delete');
Route::patch('/admin/question-bank/{file}/approve', [AdminController::class, 'approveQuestionBankFile'])->name('admin.questionbank.approve');
Route::get('/admin/question-bank/{file}/download', [AdminController::class, 'downloadQuestionBankFile'])->name('admin.questionbank.download');

// Course Material Admin Routes
Route::get('/admin/course-materials/{courseMaterial}/download', [AdminController::class, 'downloadCourseMaterial'])->name('admin.coursematerial.download');
Route::patch('/admin/course-materials/{courseMaterial}/approve', [AdminController::class, 'approveCourseMaterial'])->name('admin.coursematerial.approve');
Route::delete('/admin/course-materials/{courseMaterial}', [AdminController::class, 'deleteCourseMaterial'])->name('admin.coursematerial.delete');

// 2. Planner Routes (Teammate's Work)
Route::get('/course-planner', [PlannerController::class, 'course'])->name('course.planner');
Route::get('/section-planner', [PlannerController::class, 'section'])->name('section.planner');

Route::get('/academic-calendar', [AcademicCalendarController::class, 'index'])->name('academic.calendar');

// 3. Protected Routes (Requires Login)
Route::middleware(['auth'])->group(function () {

    // Dashboard main page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Calculator Routes
    Route::get('/calculator/cgpa', [DashboardController::class, 'cgpaCalculator'])->name('calculator.cgpa');

    /*
    |--------------------------------------------------------------------------
    | NEW: Tuition Fee Calculator Route
    |--------------------------------------------------------------------------
    */
    Route::get('/calculator/tuition', [DashboardController::class, 'tuitionCalculator'])->name('calculator.tuition');

    // To-do list (Add, Toggle, Delete)
    Route::post('/tasks', [DashboardController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [DashboardController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [DashboardController::class, 'destroy'])->name('tasks.destroy');

    // Question Bank
    Route::get('/academic-hub/question-bank', [QuestionBankController::class, 'index'])->name('question.bank');
    Route::post('/academic-hub/question-bank', [QuestionBankController::class, 'store'])->name('question.bank.store');
    Route::get('/academic-hub/question-bank/{file}/download', [QuestionBankController::class, 'download'])->name('question.bank.download');
    Route::delete('/academic-hub/question-bank/{file}', [QuestionBankController::class, 'destroy'])->name('question.bank.destroy');

    // Course Material Routes
    Route::get('/academic-hub/course-material', [CourseMaterialController::class, 'index'])->name('course.material');
    Route::post('/academic-hub/course-material', [CourseMaterialController::class, 'store'])->name('course.material.store');
    Route::delete('/academic-hub/course-material/{courseMaterial}', [CourseMaterialController::class, 'destroy'])->name('course.material.destroy');
    Route::get('/academic-hub/course-material/{courseMaterial}/download', [CourseMaterialController::class, 'download'])->name('course.material.download');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Community Routes
    Route::get('/community', [CommunityController::class, 'index'])->name('community');
    Route::get('/community/group/{groupId}', [CommunityController::class, 'showGroup'])->name('community.group');
    Route::post('/community/group/{groupId}/message', [CommunityController::class, 'sendMessage'])->name('community.message.send');
    Route::post('/community/group/{groupId}/message/{message}/report', [CommunityController::class, 'reportMessage'])->name('community.message.report');
    Route::get('/community/group/{groupId}/messages', [CommunityController::class, 'getMessages'])->name('community.messages.get');

    // Planner Save Routes
    Route::post('/course-planner/save', [PlannerController::class, 'saveCourseRoutine'])->name('course.planner.save');
    Route::post('/section-planner/save', [PlannerController::class, 'saveSectionRoutine'])->name('section.planner.save');
});