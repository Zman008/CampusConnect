<?php

namespace App\Http\Controllers;

use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = CourseMaterial::with('user')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('course_code', 'like', "%{$search}%")
                  ->orWhere('course_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $materials = $query->get();
        $grouped   = $materials->groupBy('course_code')->map(fn($items) => $items->groupBy('type'));

        return view('courseMaterial', compact('grouped', 'search', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:pdf,slides,assignment,book',
            'file'        => 'required|file|mimes:pdf,ppt,pptx,doc,docx|max:20480',
        ], [
            'course_code.required' => '⚠️ Please enter the course code.',
            'course_name.required' => '⚠️ Please enter the course name.',
            'title.required'       => '⚠️ Please enter a title.',
            'type.required'        => '⚠️ Please select a material type.',
            'file.required'        => '⚠️ Please select a file to upload.',
            'file.mimes'           => '⚠️ Only PDF, PPT, PPTX, DOC, DOCX files allowed.',
            'file.max'             => '⚠️ File size must be less than 20MB.',
        ]);

        $file = $request->file('file');
        $path = $file->store('course-materials', 'public');

        CourseMaterial::create([
            'user_id'     => Auth::id(),
            'course_code' => strtoupper($request->course_code),
            'course_name' => $request->course_name,
            'title'       => $request->title,
            'type'        => $request->type,
            'file_path'   => $path,
            'file_name'   => $file->getClientOriginalName(),
            'file_size'   => $file->getSize(),
        ]);

        return redirect()->route('course.material')->with('success', '✅ Material uploaded successfully!');
    }

    public function destroy(CourseMaterial $courseMaterial)
    {
        abort_unless(session('is_admin'), 403);
        Storage::disk('public')->delete($courseMaterial->file_path);
        $courseMaterial->delete();
        return redirect()->back()->with('success', '🗑️ Material deleted.');
    }

    public function download(CourseMaterial $courseMaterial)
    {
        return Storage::disk('public')->download($courseMaterial->file_path, $courseMaterial->file_name);
    }
}