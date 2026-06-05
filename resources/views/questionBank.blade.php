<x-layout>
    <x-slot name="title">Question Bank – CampusConnect</x-slot>

    <div class="min-h-screen bg-gray-100 pt-24 pb-16 px-4">
        <div class="max-w-6xl mx-auto">

            {{-- Hero --}}
            <div class="relative bg-gradient-to-r from-[#003366] to-blue-800 rounded-2xl px-10 py-8 text-white mb-8 overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-2xl font-extrabold mb-1">UIU CSE Question Bank</h1>
                    <p class="text-blue-200 text-sm">Browse past exam questions by semester & subject. Students can also upload their own question papers for others to download.</p>
                </div>
                <div class="absolute right-10 top-1/2 -translate-y-1/2 text-8xl opacity-10 select-none">📚</div>
            </div>

            {{-- Success / Error --}}
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl mb-6">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-4 py-3 rounded-xl mb-6">
                <span class="material-symbols-outlined text-lg mt-0.5">error</span>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            {{-- Upload Section --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <span class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-700 text-lg">upload_file</span>
                    </span>
                    <div>
                        <h2 class="font-extrabold text-[#003366] text-base">Upload Question Paper</h2>
                        <p class="text-xs text-gray-400">Share a past question paper with other students (PDF only, max 10MB)</p>
                    </div>
                    <button onclick="toggleUpload()" id="uploadToggleBtn"
                        class="ml-auto px-4 py-2 bg-[#003366] text-white text-sm font-bold rounded-xl hover:bg-blue-900 transition-colors">
                        + Upload
                    </button>
                </div>

                <div id="uploadForm" class="hidden">
                    <form action="{{ route('question.bank.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Course Code *</label>
                                <input type="text" name="course_code" placeholder="e.g. CSE2111"
                                    value="{{ old('course_code') }}"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Course Name *</label>
                                <input type="text" name="course_name" placeholder="e.g. Data Structures"
                                    value="{{ old('course_name') }}"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Semester *</label>
                                <select name="semester" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">Select semester</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Exam Type *</label>
                                <select name="term" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">Select type</option>
                                    <option value="mid" {{ old('term') == 'mid' ? 'selected' : '' }}>Mid Term</option>
                                    <option value="final" {{ old('term') == 'final' ? 'selected' : '' }}>Final Exam</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Question Paper PDF *</label>
                            <input type="file" name="file" accept=".pdf"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold file:text-xs">
                        </div>
                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 bg-[#003366] text-white text-sm font-bold rounded-xl hover:bg-blue-900 transition-colors">
                                Upload Question Paper
                            </button>
                            <button type="button" onclick="toggleUpload()"
                                class="px-6 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Uploaded Questions grouped by Semester --}}
            @if($uploads->count() > 0)

                {{-- Search --}}
                <div class="relative mb-5">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl pointer-events-none">search</span>
                    <input type="text" id="searchInput" placeholder="Search by course name or code..."
                           class="w-full bg-white border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm font-medium shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                {{-- Semester tabs --}}
                <div class="flex gap-2 flex-wrap mb-6" id="semTabs">
                    <button onclick="filterSemester('all', this)" class="tab-btn active px-4 py-2 rounded-full text-sm font-bold border transition-all">All</button>
                    @foreach($uploads->groupBy('semester')->sortKeys() as $sem => $group)
                    <button onclick="filterSemester('{{ $sem }}', this)" class="tab-btn px-4 py-2 rounded-full text-sm font-bold border transition-all">Semester {{ $sem }}</button>
                    @endforeach
                </div>

                {{-- No results --}}
                <div id="noResults" class="hidden bg-white rounded-2xl border border-gray-200 shadow-sm text-center py-16 px-6 mb-6">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🔍</div>
                    <p class="font-bold text-[#003366] text-lg mb-1">No courses found</p>
                    <p class="text-gray-400 text-sm">Try a different course name or code.</p>
                </div>

                {{-- Group by semester --}}
                @foreach($uploads->groupBy('semester')->sortKeys() as $sem => $semFiles)
                <div class="semester-section mb-8" data-semester="{{ $sem }}">
                    <div class="flex items-center gap-3 mb-4 pb-3 border-b-2 border-gray-200">
                        <span class="bg-[#003366] text-white text-xs font-bold px-3 py-1.5 rounded-lg">Semester {{ $sem }}</span>
                        <span class="font-bold text-gray-800">{{ $semFiles->count() }} question {{ Str::plural('paper', $semFiles->count()) }}</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($semFiles as $file)
                        <div class="course-card bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md hover:-translate-y-0.5 transition-all"
                             data-name="{{ strtolower($file->course_code.' '.$file->course_name) }}"
                             data-sem="{{ $sem }}">
                            <div class="flex items-start gap-3 mb-4">
                                <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-lg whitespace-nowrap flex-shrink-0">
                                    {{ $file->course_code }}
                                </span>
                                <div>
                                    <div class="font-bold text-gray-800 text-sm leading-tight">{{ $file->course_name }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">Semester {{ $file->semester }} • by {{ $file->user->username }}</div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 {{ $file->term === 'mid' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-red-50 text-red-600 border-red-100' }} border rounded-lg text-xs font-semibold">
                                    {{ $file->term === 'mid' ? '📄 Mid Term' : '📋 Final Exam' }}
                                </span>
                                <a href="{{ route('question.bank.download', $file) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#003366] text-white rounded-lg text-xs font-semibold hover:bg-blue-900 transition-colors">
                                    ⬇️ Download
                                </a>
                                <form method="POST" action="{{ route('question.bank.destroy', $file) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Delete this question paper?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 border border-red-100 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

            @else

                {{-- Empty state --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm text-center py-20 px-6">
                    <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-5">📭</div>
                    <p class="font-extrabold text-[#003366] text-xl mb-2">No question papers yet</p>
                    <p class="text-gray-400 text-sm mb-6">Be the first to upload a question paper for your classmates!</p>
                    <button onclick="toggleUpload()"
                        class="px-6 py-2.5 bg-[#003366] text-white text-sm font-bold rounded-xl hover:bg-blue-900 transition-colors">
                        + Upload First Question Paper
                    </button>
                </div>

            @endif

        </div>
    </div>

    <style>
        .tab-btn { background: white; color: #64748b; border-color: #e2e8f0; }
        .tab-btn:hover { border-color: #1a6ccd; color: #1a6ccd; }
        .tab-btn.active { background: #003366; color: white; border-color: #003366; }
    </style>

    @push('scripts')
    <script>
        function toggleUpload() {
            const form = document.getElementById('uploadForm');
            form.classList.toggle('hidden');
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        @if($errors->any())
            document.getElementById('uploadForm').classList.remove('hidden');
        @endif

        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                const sections = document.querySelectorAll('.semester-section');
                let anyVisible = false;

                sections.forEach(section => {
                    let sectionHasVisible = false;
                    section.querySelectorAll('.course-card').forEach(card => {
                        const match = !q || card.dataset.name.includes(q);
                        card.style.display = match ? '' : 'none';
                        if (match) { sectionHasVisible = true; anyVisible = true; }
                    });
                    section.style.display = sectionHasVisible ? '' : 'none';
                });

                const noResults = document.getElementById('noResults');
                if (noResults) noResults.classList.toggle('hidden', anyVisible);
            });
        }

        function filterSemester(sem, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const searchInput = document.getElementById('searchInput');
            if (searchInput) searchInput.value = '';
            const noResults = document.getElementById('noResults');
            if (noResults) noResults.classList.add('hidden');
            document.querySelectorAll('.semester-section').forEach(section => {
                section.style.display = (sem === 'all' || section.dataset.semester === sem) ? '' : 'none';
            });
            document.querySelectorAll('.course-card').forEach(card => card.style.display = '');
        }
    </script>
    @endpush

</x-layout>