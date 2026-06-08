<?php

namespace App\Http\Controllers;

use App\Models\CommunityGroup;
use App\Models\CommunityMessage;
use App\Models\CourseMaterial;
use App\Models\ExamRoutine;
use App\Models\SectionRoutine;
use App\Models\User;
use App\Models\QuestionBankFile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        if (! session('is_admin')) {
            return view('admin.login');
        }

        return view('admin.dashboard', [
            'groups' => CommunityGroup::withCount('messages')->orderBy('name')->get(),
            'examRoutines' => ExamRoutine::orderBy('course_code')->get(),
            'sectionRoutines' => SectionRoutine::orderBy('course_code')->orderBy('section')->get(),
            'reportedMessages' => CommunityMessage::with(['user', 'group', 'reportedBy'])
                ->whereNotNull('reported_at')
                ->latest('reported_at')
                ->get(),
            'questionBankFiles' => QuestionBankFile::with('user')->latest()->get(),
            'courseMaterials' => CourseMaterial::with('user')->latest()->get(),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($credentials['username'] === 'admin' && $credentials['password'] === 'admin') {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);

            return redirect()->route('admin.index')->with('success', 'Admin signed in.');
        }

        return back()->withErrors([
            'username' => 'The admin credentials are incorrect.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');

        return redirect()->route('admin.index')->with('success', 'Admin signed out.');
    }

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

    public function deleteQuestionBankFile(QuestionBankFile $file)
    {
        $this->ensureAdmin();
        \Illuminate\Support\Facades\Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect(route('admin.index') . '#questionbank')->with('success', 'Question paper deleted.');
    }

    public function approveQuestionBankFile(QuestionBankFile $file)
    {
        $this->ensureAdmin();
        $file->update(['status' => 'approved']);

        return redirect(route('admin.index') . '#questionbank')->with('success', 'Question paper approved.');
    }

    public function downloadQuestionBankFile(QuestionBankFile $file)
    {
        $this->ensureAdmin();

        return \Illuminate\Support\Facades\Storage::disk('public')->download(
            $file->file_path,
            $file->original_name
        );
    }

    public function downloadCourseMaterial(CourseMaterial $courseMaterial)
    {
        $this->ensureAdmin();

        return \Illuminate\Support\Facades\Storage::disk('public')->download(
            $courseMaterial->file_path,
            $courseMaterial->file_name
        );
    }

    public function approveCourseMaterial(CourseMaterial $courseMaterial)
    {
        $this->ensureAdmin();
        $courseMaterial->update(['status' => 'approved']);

        return redirect(route('admin.index') . '#coursematerial')->with('success', 'Course material approved.');
    }

    public function deleteCourseMaterial(CourseMaterial $courseMaterial)
    {
        $this->ensureAdmin();
        \Illuminate\Support\Facades\Storage::disk('public')->delete($courseMaterial->file_path);
        $courseMaterial->delete();

        return redirect(route('admin.index') . '#coursematerial')->with('success', 'Course material deleted.');
    }

    private function validateExamRoutine(Request $request, ?ExamRoutine $examRoutine = null): array
    {
        return $request->validate([
            'course_code' => [
                'required',
                'string',
                'max:255',
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

    private function ensureAdmin(): void
    {
        abort_unless(session('is_admin'), 403);
    }
}