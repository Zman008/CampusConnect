<x-layout>
    <x-slot name="title">Course Material – CampusConnect</x-slot>

    <div class="min-h-screen bg-gray-100 pt-24 pb-16 px-4">
        <div class="max-w-6xl mx-auto">

            {{-- Flash --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 font-semibold text-sm px-4 py-3 rounded-xl mb-6">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Hero --}}
            <div class="relative bg-gradient-to-r from-[#003366] to-blue-800 rounded-2xl px-10 py-8 text-white mb-8 overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-2xl font-extrabold mb-1">Course Material Library</h1>
                    <p class="text-blue-200 text-sm">Upload and access PDFs, slides, assignments & books — all in one place.</p>
                </div>
                <div class="absolute right-10 top-1/2 -translate-y-1/2 text-8xl opacity-10">📂</div>
            </div>

            {{-- Stats --}}
            @php
                $total      = $materials->count();
                $pdfCount   = $materials->where('type','pdf')->count();
                $slideCount = $materials->where('type','slides')->count();
                $assCount   = $materials->where('type','assignment')->count();
                $bookCount  = $materials->where('type','book')->count();
            @endphp
            @if($total > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-lg">📄</div>
                    <div>
                        <div class="text-2xl font-extrabold text-[#003366]">{{ $pdfCount }}</div>
                        <div class="text-xs text-gray-400 font-medium uppercase tracking-wide">PDFs</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-lg">📊</div>
                    <div>
                        <div class="text-2xl font-extrabold text-[#003366]">{{ $slideCount }}</div>
                        <div class="text-xs text-gray-400 font-medium uppercase tracking-wide">Slides</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-lg">📝</div>
                    <div>
                        <div class="text-2xl font-extrabold text-[#003366]">{{ $assCount }}</div>
                        <div class="text-xs text-gray-400 font-medium uppercase tracking-wide">Assignments</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-lg">📗</div>
                    <div>
                        <div class="text-2xl font-extrabold text-[#003366]">{{ $bookCount }}</div>
                        <div class="text-xs text-gray-400 font-medium uppercase tracking-wide">Books</div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Upload Form --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
                <button onclick="toggleUpload()" class="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3 font-bold text-[#003366]">
                        <span class="material-symbols-outlined text-xl">upload_file</span>
                        Upload New Material
                    </div>
                    <span class="material-symbols-outlined text-gray-400 transition-transform duration-300" id="uploadChevron">expand_more</span>
                </button>

                <div id="uploadBody" class="hidden border-t border-gray-100 px-6 pb-6">
                    <form action="{{ route('course.material.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">

                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Course Code *</label>
                                <input type="text" name="course_code" placeholder="e.g. CSE2111"
                                       value="{{ old('course_code') }}"
                                       class="bg-gray-50 border {{ $errors->has('course_code') ? 'border-red-400' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                @error('course_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Course Name *</label>
                                <input type="text" name="course_name" placeholder="e.g. Object Oriented Programming"
                                       value="{{ old('course_name') }}"
                                       class="bg-gray-50 border {{ $errors->has('course_name') ? 'border-red-400' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                @error('course_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Material Title *</label>
                                <input type="text" name="title" placeholder="e.g. Chapter 3 Lecture Slides"
                                       value="{{ old('title') }}"
                                       class="bg-gray-50 border {{ $errors->has('title') ? 'border-red-400' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Material Type *</label>
                                <select name="type"
                                        class="bg-gray-50 border {{ $errors->has('type') ? 'border-red-400' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">-- Select type --</option>
                                    <option value="pdf"        {{ old('type') === 'pdf'        ? 'selected' : '' }}>📄 PDF</option>
                                    <option value="slides"     {{ old('type') === 'slides'     ? 'selected' : '' }}>📊 Slides</option>
                                    <option value="assignment" {{ old('type') === 'assignment' ? 'selected' : '' }}>📝 Assignment</option>
                                    <option value="book"       {{ old('type') === 'book'       ? 'selected' : '' }}>📗 Book</option>
                                </select>
                                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex flex-col gap-1 md:col-span-2">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">File *</label>
                                <input type="file" name="file" accept=".pdf,.ppt,.pptx,.doc,.docx"
                                       class="bg-gray-50 border {{ $errors->has('file') ? 'border-red-400' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:border-blue-500">
                                <p class="text-xs text-gray-400 mt-1">Allowed: PDF, PPT, PPTX, DOC, DOCX — Max 20MB</p>
                                @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                        </div>
                        <button type="submit"
                                class="mt-5 inline-flex items-center gap-2 px-6 py-3 bg-[#003366] hover:bg-blue-900 text-white font-bold text-sm rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg">
                            <span class="material-symbols-outlined text-base">cloud_upload</span>
                            Upload Material
                        </button>
                    </form>
                </div>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('course.material') }}" class="relative mb-5">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl pointer-events-none">search</span>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Search by course code, name or title..."
                       class="w-full bg-white border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm font-medium shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            </form>

            {{-- Legend --}}
            <div class="flex gap-2 flex-wrap mb-6">
                <span class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3 py-1.5 rounded-full"><span class="w-2 h-2 rounded-full bg-red-500"></span>PDF</span>
                <span class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3 py-1.5 rounded-full"><span class="w-2 h-2 rounded-full bg-blue-500"></span>Slides</span>
                <span class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3 py-1.5 rounded-full"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Assignment</span>
                <span class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3 py-1.5 rounded-full"><span class="w-2 h-2 rounded-full bg-green-500"></span>Book</span>
            </div>

            {{-- Materials --}}
            @if($grouped->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm text-center py-16 px-6">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">📂</div>
                    <p class="font-bold text-[#003366] text-lg mb-1">{{ $search ? 'No results found' : 'No materials yet' }}</p>
                    <p class="text-gray-400 text-sm">{{ $search ? 'Try a different search term.' : 'Be the first to upload a course material!' }}</p>
                </div>
            @else
                @foreach($grouped as $courseCode => $typeGroups)
                    @php $courseName = $typeGroups->flatten()->first()->course_name; @endphp
                    <div class="mb-8">
                        {{-- Course header --}}
                        <div class="flex items-center gap-3 mb-4 pb-3 border-b-2 border-gray-200">
                            <span class="bg-[#003366] text-white text-xs font-bold px-3 py-1.5 rounded-lg">{{ $courseCode }}</span>
                            <span class="font-bold text-gray-800">{{ $courseName }}</span>
                            <span class="ml-auto text-xs text-gray-400 font-medium">{{ $typeGroups->flatten()->count() }} file(s)</span>
                        </div>

                        @foreach(['pdf' => ['📄','red','PDF'], 'slides' => ['📊','blue','Slides'], 'assignment' => ['📝','amber','Assignments'], 'book' => ['📗','green','Books']] as $type => [$icon, $color, $label])
                            @if(isset($typeGroups[$type]))
                                <div class="mb-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="w-2 h-2 rounded-full bg-{{ $color }}-500"></span>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $label }}</span>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        @foreach($typeGroups[$type] as $material)
                                        <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all">
                                            <div class="w-10 h-10 bg-{{ $color }}-50 rounded-xl flex items-center justify-center text-xl flex-shrink-0">{{ $icon }}</div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-semibold text-gray-800 text-sm truncate">{{ $material->title }}</div>
                                                <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                                                    <span>{{ $material->file_size_formatted }}</span>
                                                    <span>·</span>
                                                    <span>by {{ $material->user->name ?? 'Unknown' }}</span>
                                                    <span>·</span>
                                                    <span>{{ $material->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <a href="{{ route('course.material.download', $material) }}"
                                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors">
                                                    <span class="material-symbols-outlined text-sm">download</span>
                                                    Download
                                                </a>
                                                @if(Auth::id() === $material->user_id || (Auth::user()->is_admin ?? false))
                                                <form action="{{ route('course.material.destroy', $material) }}" method="POST"
                                                      onsubmit="return confirm('Delete this material?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 text-red-500 border border-red-100 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors">
                                                        <span class="material-symbols-outlined text-sm">delete</span>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            @endif

        </div>
    </div>

    <script>
        function toggleUpload() {
            const body    = document.getElementById('uploadBody');
            const chevron = document.getElementById('uploadChevron');
            const isOpen  = !body.classList.contains('hidden');
            body.classList.toggle('hidden', isOpen);
            chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
        }

        // Auto open if there are validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', () => toggleUpload());
        @endif
    </script>

</x-layout>
