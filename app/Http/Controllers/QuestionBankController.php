<?php

namespace App\Http\Controllers;

class QuestionBankController
{
    public function index()
    {
        $uploads = \App\Models\QuestionBankFile::with('user')
                    ->latest()
                    ->get();

        return view('questionBank', compact('uploads'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:100',
            'semester'    => 'required|integer|min:1|max:12',
            'term'        => 'required|in:mid,final',
            'file'        => 'required|file|mimes:pdf|max:10240',
        ]);

        $path = $request->file('file')->store('question-bank', 'public');

        \App\Models\QuestionBankFile::create([
            'user_id'       => auth()->id(),
            'course_code'   => $request->course_code,
            'course_name'   => $request->course_name,
            'semester'      => $request->semester,
            'term'          => $request->term,
            'file_path'     => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
        ]);

        return back()->with('success', 'Question paper uploaded successfully!');
    }

    public function download(\App\Models\QuestionBankFile $file)
    {
        return \Illuminate\Support\Facades\Storage::disk('public')->download(
            $file->file_path,
            $file->original_name
        );
    }

    public function destroy(\App\Models\QuestionBankFile $file)
    {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'Question paper deleted successfully!');
    }
}