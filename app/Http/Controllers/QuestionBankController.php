<?php

namespace App\Http\Controllers;

use App\Models\QuestionBankFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionBankController extends Controller
{
    public function index()
    {
        // Students only see APPROVED files
        $uploads = QuestionBankFile::with('user')
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('questionBank', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:100',
            'semester'    => 'required|integer|min:1|max:12',
            'term'        => 'required|in:mid,final',
            'file'        => 'required|file|mimes:pdf|max:10240',
        ]);

        $path = $request->file('file')->store('question-bank', 'public');

        QuestionBankFile::create([
            'user_id'       => auth()->id(),
            'course_code'   => $request->course_code,
            'course_name'   => $request->course_name,
            'semester'      => $request->semester,
            'term'          => $request->term,
            'file_path'     => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
            'status'        => 'pending', // always pending on upload
        ]);

        return back()->with('success', 'Question paper uploaded! Waiting for admin approval.');
    }

    public function download(QuestionBankFile $file)
    {
        return Storage::disk('public')->download(
            $file->file_path,
            $file->original_name
        );
    }

    public function destroy(QuestionBankFile $file)
    {
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'Question paper deleted successfully!');
    }
}