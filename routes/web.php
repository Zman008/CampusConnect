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

/*
|--------------------------------------------------------------------------
| 1. Guest Routes (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| 2. Admin Panel Routes (Management)
|--------------------------------------------------------------------------
*/
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Group & Reports
Route::post('/admin/groups', [AdminController::class, 'storeGroup'])->name('admin.groups.store');
Route::delete('/admin/groups/{group}', [AdminController::class, 'deleteGroup'])->name('admin.groups.delete');
Route::patch('/admin/users/{user}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');
Route::patch('/admin/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('admin.users.unban');

// Routine Management
Route::post('/admin/exam-routines', [AdminController::class, 'storeExamRoutine'])->name('admin.exam-routines.store');
Route::patch('/admin/exam-routines/{examRoutine}', [AdminController::class, 'updateExamRoutine'])->name('admin.exam-routines.update');
Route::delete('/admin/exam-routines/{examRoutine}', [AdminController::class, 'deleteExamRoutine'])->name('admin.exam-routines.delete');
Route::post('/admin/section-routines', [AdminController::class, 'storeSectionRoutine'])->name('admin.section-routines.store');
Route::patch('/admin/section-routines/{sectionRoutine}', [AdminController::class, 'updateSectionRoutine'])->name('admin.section-routines.update');
Route::delete('/admin/section-routines/{sectionRoutine}', [AdminController::class, 'deleteSectionRoutine'])->name('admin.section-routines.delete');
Route::delete('/admin/question-bank/{file}', [AdminController::class, 'deleteQuestionBankFile'])->name('admin.questionbank.delete');

/**
 * ADMIN: Class Link Management
 * Route for admin to delete user-submitted links.
 */
Route::delete('/admin/class-links/{classLink}', [AdminController::class, 'deleteClassLink'])->name('admin.links.delete');

/*
|--------------------------------------------------------------------------
| 3. Shared Resources (Planner & Calendar)
|--------------------------------------------------------------------------
*/
Route::get('/course-planner', [PlannerController::class, 'course'])->name('course.planner');
Route::get('/section-planner', [PlannerController::class, 'section'])->name('section.planner');
Route::get('/academic-calendar', [AcademicCalendarController::class, 'index'])->name('academic.calendar');

/*
|--------------------------------------------------------------------------
| 4. Protected Routes (Requires Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * ACADEMIC HUB: Class Links & Submissions
     */
    Route::get('/academic-hub/class-links', [DashboardController::class, 'classLinks'])->name('class.links');
    Route::post('/academic-hub/class-links', [DashboardController::class, 'storeClassLink'])->name('class.links.store');

    // Calculator Routes
    Route::get('/calculator/cgpa', [DashboardController::class, 'cgpaCalculator'])->name('calculator.cgpa');
    Route::get('/calculator/tuition', [DashboardController::class, 'tuitionCalculator'])->name('calculator.tuition');

    // To-do list Actions
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

    // Community & Chat
    Route::get('/community', [CommunityController::class, 'index'])->name('community');
    Route::get('/community/group/{groupId}', [CommunityController::class, 'showGroup'])->name('community.group');
    Route::post('/community/group/{groupId}/message', [CommunityController::class, 'sendMessage'])->name('community.message.send');
    Route::post('/community/group/{groupId}/message/{message}/report', [CommunityController::class, 'reportMessage'])->name('community.message.report');
    Route::get('/community/group/{groupId}/messages', [CommunityController::class, 'getMessages'])->name('community.messages.get');

    // Planner Saving
    Route::post('/course-planner/save', [PlannerController::class, 'saveCourseRoutine'])->name('course.planner.save');
    Route::post('/section-planner/save', [PlannerController::class, 'saveSectionRoutine'])->name('section.planner.save');
});