<?php

namespace App\Http\Controllers;

use App\Models\CommunityGroup;
use App\Models\CommunityMessage;
use App\Models\ExamRoutine;
use App\Models\SectionRoutine;
use App\Models\ClassLink; // Essential model for University Class Links
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     * 
     * Loads groups, routines, reported messages, and the newly integrated 
     * class links submitted by students/teachers for administrative review.
     */
    public function index()
    {
        // Session-based security check for admin access
        if (! session('is_admin')) {
            return view('admin.login');
        }

        return view('admin.dashboard', [
            'groups' => CommunityGroup::withCount('messages')->orderBy('name')->get(),
            'examRoutines' => ExamRoutine::orderBy('course_code')->get(),
            'sectionRoutines' => SectionRoutine::orderBy('course_code')->orderBy('section')->get(),
            
            // Fetching all submitted class links with uploader info for management
            'classLinks' => ClassLink::with('user')->latest()->get(), 
            
            'reportedMessages' => CommunityMessage::with(['user', 'group', 'reportedBy'])
                ->whereNotNull('reported_at')
                ->latest('reported_at')
                ->get(),
        ]);
    }

    /**
     * Handle Admin Authentication.
     * 
     * Simple username/password check for prototype purposes.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($credentials['username'] === 'admin' && $credentials['password'] === 'admin') {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);

            return redirect()->route('admin.index')->with('success', 'Admin signed in successfully.');
        }

        return back()->withErrors([
            'username' => 'The admin credentials provided are incorrect.',
        ])->onlyInput('username');
    }

    /**
     * Log the admin out and clear the admin session.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');

        return redirect()->route('admin.index')->with('success', 'Admin signed out.');
    }

    /**
     * Remove a specific class link from the hub.
     * 
     * Action intended for moderators to clean up invalid or expired links.
     */
    public function deleteClassLink(ClassLink $classLink)
    {
        $this->ensureAdmin();
        $classLink->delete();

        // Redirecting back to the links section using anchor tag
        return redirect(route('admin.index') . '#links')->with('success', 'Class link has been removed.');
    }

    /* 
    |--------------------------------------------------------------------------
    | Community Management Logic
    |--------------------------------------------------------------------------
    */

    public function storeGroup(Request $request)
    {
        $this->ensureAdmin();
        CommunityGroup::create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ]));
        return back()->with('success', 'Community group created.');
    }

    public function deleteGroup(CommunityGroup $group)
    {
        $this->ensureAdmin();
        $group->delete();
        return back()->with('success', 'Community group deleted.');
    }

    /* 
    |--------------------------------------------------------------------------
    | Moderation & User Reporting Logic
    |--------------------------------------------------------------------------
    */

    public function banUser(User $user)
    {
        $this->ensureAdmin();
        $user->forceFill(['banned_at' => now()])->save();
        return redirect(route('admin.index') . '#reports')->with('success', "{$user->username} has been banned.");
    }

    public function unbanUser(User $user)
    {
        $this->ensureAdmin();
        $user->forceFill(['banned_at' => null])->save();
        return redirect(route('admin.index') . '#reports')->with('success', "{$user->username} has been unbanned.");
    }

    /* 
    |--------------------------------------------------------------------------
    | Routine Management Logic (Exam & Section)
    |--------------------------------------------------------------------------
    */

    public function storeExamRoutine(Request $request)
    {
        $this->ensureAdmin();
        ExamRoutine::create($this->validateExamRoutine($request));
        return redirect(route('admin.index') . '#exam')->with('success', 'Exam routine added.');
    }

    public function updateExamRoutine(Request $request, ExamRoutine $examRoutine)
    {
        $this->ensureAdmin();
        $examRoutine->update($this->validateExamRoutine($request, $examRoutine));
        return redirect(route('admin.index') . '#exam')->with('success', 'Exam routine updated.');
    }

    public function deleteExamRoutine(ExamRoutine $examRoutine)
    {
        $this->ensureAdmin();
        $examRoutine->delete();
        return redirect(route('admin.index') . '#exam')->with('success', 'Exam routine deleted.');
    }

    public function storeSectionRoutine(Request $request)
    {
        $this->ensureAdmin();
        SectionRoutine::create($this->validateSectionRoutine($request));
        return redirect(route('admin.index') . '#section')->with('success', 'Section routine added.');
    }

    public function updateSectionRoutine(Request $request, SectionRoutine $sectionRoutine)
    {
        $this->ensureAdmin();
        $sectionRoutine->update($this->validateSectionRoutine($request));
        return redirect(route('admin.index') . '#section')->with('success', 'Section routine updated.');
    }

    public function deleteSectionRoutine(SectionRoutine $sectionRoutine)
    {
        $this->ensureAdmin();
        $sectionRoutine->delete();
        return redirect(route('admin.index') . '#section')->with('success', 'Section routine deleted.');
    }

    /* 
    |--------------------------------------------------------------------------
    | Validation Helpers & Security
    |--------------------------------------------------------------------------
    */

    private function validateExamRoutine(Request $request, ?ExamRoutine $examRoutine = null): array
    {
        return $request->validate([
            'course_code' => [
                'required', 'string', 'max:255',
                Rule::unique('exam_routines', 'course_code')->ignore($examRoutine),
            ],
            'course_name' => ['required', 'string', 'max:255'],
            'day' => ['required', 'integer', 'min:1'],
            'time_slot' => ['required', 'integer', 'min:1'],
        ]);
    }

    private function validateSectionRoutine(Request $request): array
    {
        return $request->validate([
            'course_code' => ['required', 'string', 'max:255'],
            'course_short_name' => ['required', 'string', 'max:255'],
            'course_title' => ['required', 'string', 'max:255'],
            'section' => ['required', 'string', 'max:255'],
            'days' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'faculty_name' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Check if the current session is an authorized admin session.
     */
    private function ensureAdmin(): void
    {
        abort_unless(session('is_admin'), 403, 'Unauthorized administrative access.');
    }
}