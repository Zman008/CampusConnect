<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | CampusConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <main class="min-h-screen py-8 bg-slate-100">
        <div class="max-w-[1500px] mx-auto px-5 md:px-8 space-y-6">
            <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase text-blue-700">CampusConnect</p>
                    <h1 class="text-4xl font-black text-[#003366]">Admin Panel</h1>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-700">Admin Logout</button>
                </form>
            </header>

            @if (session('success'))
                <div class="rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm font-semibold text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm font-semibold text-red-800">
                    {{ $errors->first() }}
                </div>
            @endif

            <nav class="bg-white border border-slate-200 rounded-lg p-2 shadow-sm flex flex-wrap gap-2">
                <button type="button" class="admin-tab rounded-lg px-4 py-2.5 text-sm font-bold transition-colors bg-[#003366] text-white" data-tab-target="groups">
                    Groups
                </button>
                <button type="button" class="admin-tab rounded-lg px-4 py-2.5 text-sm font-bold transition-colors text-slate-600 hover:bg-slate-100" data-tab-target="exam">
                    Exam Routine
                </button>
                <button type="button" class="admin-tab rounded-lg px-4 py-2.5 text-sm font-bold transition-colors text-slate-600 hover:bg-slate-100" data-tab-target="section">
                    Section Routine
                </button>
                <button type="button" class="admin-tab rounded-lg px-4 py-2.5 text-sm font-bold transition-colors text-slate-600 hover:bg-slate-100" data-tab-target="questionbank">
                    Question Bank
                    @if ($questionBankFiles->count())
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-0.5 text-xs text-blue-700">{{ $questionBankFiles->count() }}</span>
                    @endif
                </button>
                <button type="button" class="admin-tab rounded-lg px-4 py-2.5 text-sm font-bold transition-colors text-slate-600 hover:bg-slate-100" data-tab-target="coursematerial">
                    Course Material
                    @if ($courseMaterials->count())
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-0.5 text-xs text-blue-700">{{ $courseMaterials->count() }}</span>
                    @endif
                </button>
                <button type="button" class="admin-tab rounded-lg px-4 py-2.5 text-sm font-bold transition-colors text-slate-600 hover:bg-slate-100" data-tab-target="reports">
                    Reports
                    @if ($reportedMessages->count())
                        <span class="ml-2 rounded-full bg-red-100 px-2 py-0.5 text-xs text-red-700">{{ $reportedMessages->count() }}</span>
                    @endif
                </button>
            </nav>

            <section id="admin-tab-groups" class="admin-panel bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-black text-[#003366] mb-4">Community Groups</h2>
                <form method="POST" action="{{ route('admin.groups.store') }}" class="grid grid-cols-1 md:grid-cols-[1fr_2fr_auto] gap-3 mb-5">
                    @csrf
                    <input name="name" placeholder="Group name" required class="rounded-lg border border-slate-300 px-4 py-3">
                    <input name="description" placeholder="Description" required class="rounded-lg border border-slate-300 px-4 py-3">
                    <button class="rounded-lg bg-blue-700 px-5 py-3 font-bold text-white hover:bg-blue-800">Create</button>
                </form>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                    @forelse ($groups as $group)
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-black text-slate-900">{{ $group->name }}</h3>
                                    <p class="text-sm text-slate-600 mt-1">{{ $group->description }}</p>
                                    <p class="text-xs font-semibold text-slate-400 mt-2">{{ $group->messages_count }} messages</p>
                                </div>
                                <form method="POST" action="{{ route('admin.groups.delete', $group) }}" onsubmit="return confirm('Delete this group and its messages?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500">No community groups yet.</p>
                    @endforelse
                </div>
            </section>

            <section id="admin-tab-exam" class="admin-panel hidden bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-black text-[#003366] mb-4">Exam Routine</h2>
                <form method="POST" action="{{ route('admin.exam-routines.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-5">
                    @csrf
                    <input name="course_code" placeholder="Course code" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="course_name" placeholder="Course name" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="day" type="number" min="1" placeholder="Day" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="time_slot" type="number" min="1" placeholder="Slot" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <button class="rounded-lg bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-800">Add</button>
                </form>
                <div class="space-y-3">
                    @foreach ($examRoutines as $routine)
                        <form method="POST" action="{{ route('admin.exam-routines.update', $routine) }}" class="grid grid-cols-1 md:grid-cols-[1fr_2fr_90px_90px_auto_auto] gap-3 border border-slate-200 rounded-lg p-3">
                            @csrf
                            @method('PATCH')
                            <input name="course_code" value="{{ $routine->course_code }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="course_name" value="{{ $routine->course_name }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="day" type="number" min="1" value="{{ $routine->day }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="time_slot" type="number" min="1" value="{{ $routine->time_slot }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <button class="rounded-lg bg-slate-900 px-4 py-2 font-bold text-white hover:bg-slate-700">Update</button>
                        </form>
                        <form method="POST" action="{{ route('admin.exam-routines.delete', $routine) }}" onsubmit="return confirm('Delete this exam routine?')" class="-mt-2 flex justify-end">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    @endforeach
                </div>
            </section>

            <section id="admin-tab-section" class="admin-panel hidden bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-black text-[#003366] mb-4">Section Routine</h2>
                <form method="POST" action="{{ route('admin.section-routines.store') }}" class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-9 gap-3 mb-5">
                    @csrf
                    <input name="course_code" placeholder="Code" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="course_short_name" placeholder="Short" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="course_title" placeholder="Title" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="section" placeholder="Section" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="days" placeholder="Days" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="start_time" type="time" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="end_time" type="time" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <input name="faculty_name" placeholder="Faculty" required class="rounded-lg border border-slate-300 px-3 py-2">
                    <button class="rounded-lg bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-800">Add</button>
                </form>
                <div class="space-y-3">
                    @foreach ($sectionRoutines as $routine)
                        <form method="POST" action="{{ route('admin.section-routines.update', $routine) }}" class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-[100px_80px_2fr_50px_120px_150px_150px_1fr_auto] gap-3 border border-slate-200 rounded-lg p-3">
                            @csrf
                            @method('PATCH')
                            <input name="course_code" value="{{ $routine->course_code }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="course_short_name" value="{{ $routine->course_short_name }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="course_title" value="{{ $routine->course_title }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="section" value="{{ $routine->section }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="days" value="{{ $routine->days }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="start_time" type="time" value="{{ substr($routine->start_time, 0, 5) }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="end_time" type="time" value="{{ substr($routine->end_time, 0, 5) }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <input name="faculty_name" value="{{ $routine->faculty_name }}" required class="rounded-lg border border-slate-300 px-3 py-2">
                            <button class="rounded-lg bg-slate-900 px-4 py-2 font-bold text-white hover:bg-slate-700">Update</button>
                        </form>
                        <form method="POST" action="{{ route('admin.section-routines.delete', $routine) }}" onsubmit="return confirm('Delete this section routine?')" class="-mt-2 flex justify-end">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    @endforeach
                </div>
            </section>

            {{-- Question Bank Section --}}
            <section id="admin-tab-questionbank" class="admin-panel hidden bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-black text-[#003366] mb-4">Question Bank</h2>
                @if($questionBankFiles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                    @foreach($questionBankFiles as $file)
                    <div class="border border-slate-200 rounded-lg p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="inline-block bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-lg mb-2">{{ $file->course_code }}</span>
                                <h3 class="font-black text-slate-900">{{ $file->course_name }}</h3>
                                <p class="text-xs text-slate-500 mt-1">Semester {{ $file->semester }} • {{ $file->term === 'mid' ? 'Mid Term' : 'Final Exam' }}</p>
                                <p class="text-xs text-slate-400 mt-1">Uploaded by {{ $file->user->username ?? 'Unknown' }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.questionbank.delete', $file) }}" onsubmit="return confirm('Delete this question paper?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <p class="text-slate-500">No question papers uploaded yet.</p>
                @endif
            </section>

            {{-- Course Material Section --}}
            <section id="admin-tab-coursematerial" class="admin-panel hidden bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-black text-[#003366] mb-4">Course Material</h2>
                @if($courseMaterials->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                    @foreach($courseMaterials as $material)
                    <div class="border border-slate-200 rounded-lg p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="inline-block bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-lg mb-2">{{ $material->course_code }}</span>
                                <h3 class="font-black text-slate-900">{{ $material->title }}</h3>
                                <p class="text-xs text-slate-500 mt-1">{{ $material->course_name }} • {{ ucfirst($material->type) }}</p>
                                <p class="text-xs text-slate-400 mt-1">Uploaded by {{ $material->user->name ?? 'Unknown' }}</p>
                            </div>
                            <form method="POST" action="{{ route('course.material.destroy', $material) }}" onsubmit="return confirm('Delete this material?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <p class="text-slate-500">No course materials uploaded yet.</p>
                @endif
            </section>

            <section id="admin-tab-reports" class="admin-panel hidden bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-black text-[#003366] mb-4">Reported Messages</h2>
                <div class="space-y-3">
                    @forelse ($reportedMessages as $message)
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500">
                                        {{ $message->group->name ?? 'Deleted group' }} - reported by {{ $message->reportedBy->username ?? 'Unknown user' }} - {{ $message->reported_at ? \Illuminate\Support\Carbon::parse($message->reported_at)->format('M d, H:i') : 'Unknown time' }}
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1">{{ $message->user->username ?? 'Deleted user' }}</p>
                                    <p class="text-slate-700 mt-1">{{ $message->message }}</p>
                                    <p class="text-sm text-slate-500 mt-2">Reason: {{ $message->report_reason ?: 'No reason given' }}</p>
                                </div>
                                @if ($message->user)
                                    <form method="POST" action="{{ $message->user->banned_at ? route('admin.users.unban', $message->user) : route('admin.users.ban', $message->user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-lg px-4 py-2 text-sm font-bold {{ $message->user->banned_at ? 'bg-green-700 text-white hover:bg-green-800' : 'bg-red-700 text-white hover:bg-red-800' }}">
                                            {{ $message->user->banned_at ? 'Unban User' : 'Ban User' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500">No reported messages yet.</p>
                    @endforelse
                </div>
            </section>

        </div>
    </main>
    <script>
        const tabButtons = document.querySelectorAll('.admin-tab');
        const tabPanels = document.querySelectorAll('.admin-panel');

        function activateAdminTab(tabName) {
            tabButtons.forEach(button => {
                const isActive = button.dataset.tabTarget === tabName;
                button.classList.toggle('bg-[#003366]', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('text-slate-600', !isActive);
                button.classList.toggle('hover:bg-slate-100', !isActive);
            });

            tabPanels.forEach(panel => {
                panel.classList.toggle('hidden', panel.id !== `admin-tab-${tabName}`);
            });

            window.location.hash = tabName;
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => activateAdminTab(button.dataset.tabTarget));
        });

        const initialTab = window.location.hash.replace('#', '');
        if (['groups', 'exam', 'section', 'questionbank', 'coursematerial', 'reports'].includes(initialTab)) {
            activateAdminTab(initialTab);
        }
    </script>
</body>
</html>