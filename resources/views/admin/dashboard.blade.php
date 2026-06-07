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
            
            <!-- Header -->
            <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm font-[900] uppercase text-blue-700 tracking-widest">CampusConnect</p>
                    <h1 class="text-4xl font-[900] text-[#003366] uppercase">Admin Panel</h1>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="rounded-lg bg-slate-900 px-6 py-3 text-sm font-black text-white hover:bg-slate-700 transition-all">Admin Logout</button>
                </form>
            </header>

            <!-- Status Messages -->
            @if (session('success'))
                <div class="rounded-xl bg-green-50 border-2 border-green-200 px-6 py-4 text-sm font-black text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Navigation Tabs -->
            <nav class="bg-white border-2 border-slate-200 rounded-2xl p-2 shadow-sm flex flex-wrap gap-2">
                <button type="button" class="admin-tab rounded-xl px-5 py-3 text-sm font-black transition-all bg-[#003366] text-white" data-tab-target="groups">Groups</button>
                <button type="button" class="admin-tab rounded-xl px-5 py-3 text-sm font-black transition-all text-slate-600 hover:bg-slate-100" data-tab-target="exam">Exam Routine</button>
                <button type="button" class="admin-tab rounded-xl px-5 py-3 text-sm font-black transition-all text-slate-600 hover:bg-slate-100" data-tab-target="section">Section Routine</button>
                
                <!-- NEW: Manage Links Tab -->
                <button type="button" class="admin-tab rounded-xl px-5 py-3 text-sm font-black transition-all text-slate-600 hover:bg-slate-100" data-tab-target="links">Manage Links</button>
                
                <button type="button" class="admin-tab rounded-xl px-5 py-3 text-sm font-black transition-all text-slate-600 hover:bg-slate-100" data-tab-target="reports">
                    Reports
                    @if ($reportedMessages->count())
                        <span class="ml-2 rounded-full bg-red-500 px-2 py-0.5 text-[10px] text-white">{{ $reportedMessages->count() }}</span>
                    @endif
                </button>
            </nav>

            <!-- 1. Community Groups Panel -->
            <section id="admin-tab-groups" class="admin-panel bg-white border-2 border-slate-200 rounded-[2.5rem] p-8 shadow-sm">
                <h2 class="text-2xl font-[900] text-[#003366] mb-6 uppercase tracking-tight">Community Groups</h2>
                <form method="POST" action="{{ route('admin.groups.store') }}" class="grid grid-cols-1 md:grid-cols-[1fr_2fr_auto] gap-4 mb-8">
                    @csrf
                    <input name="name" placeholder="Group name" required class="rounded-xl border-2 border-slate-200 px-5 py-3 font-bold focus:border-blue-500 outline-none">
                    <input name="description" placeholder="Group description" required class="rounded-xl border-2 border-slate-200 px-5 py-3 font-bold focus:border-blue-500 outline-none">
                    <button class="rounded-xl bg-blue-700 px-8 py-3 font-black text-white hover:bg-blue-800 shadow-lg">CREATE</button>
                </form>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($groups as $group)
                        <div class="bg-slate-50 border-2 border-slate-100 rounded-2xl p-6 hover:border-blue-200 transition-all">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-black text-xl text-slate-900 uppercase">{{ $group->name }}</h3>
                                    <p class="text-sm font-bold text-slate-500 mt-2">{{ $group->description }}</p>
                                    <p class="text-[10px] font-black text-blue-400 mt-4 tracking-widest">{{ $group->messages_count }} MESSAGES</p>
                                </div>
                                <form method="POST" action="{{ route('admin.groups.delete', $group) }}" onsubmit="return confirm('Delete this group?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-300 hover:text-red-600 transition-colors"><span class="material-symbols-outlined font-black">delete</span></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 font-bold italic">No groups found.</p>
                    @endforelse
                </div>
            </section>

            <!-- 2. Exam Routine Panel -->
            <section id="admin-tab-exam" class="admin-panel hidden bg-white border-2 border-slate-200 rounded-[2.5rem] p-8 shadow-sm">
                <h2 class="text-2xl font-[900] text-[#003366] mb-6 uppercase tracking-tight">Exam Routine</h2>
                <form method="POST" action="{{ route('admin.exam-routines.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                    @csrf
                    <input name="course_code" placeholder="Code" required class="rounded-xl border-2 border-slate-200 px-4 py-3 font-bold">
                    <input name="course_name" placeholder="Name" required class="rounded-xl border-2 border-slate-200 px-4 py-3 font-bold">
                    <input name="day" type="number" min="1" placeholder="Day" required class="rounded-xl border-2 border-slate-200 px-4 py-3 font-bold">
                    <input name="time_slot" type="number" min="1" placeholder="Slot" required class="rounded-xl border-2 border-slate-200 px-4 py-3 font-bold">
                    <button class="rounded-xl bg-blue-700 px-6 py-3 font-black text-white hover:bg-blue-800">ADD</button>
                </form>
                <div class="space-y-4">
                    @foreach ($examRoutines as $routine)
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border-2 border-slate-100">
                            <div class="grid grid-cols-4 gap-8 flex-1 font-black text-[#003366]">
                                <span>{{ $routine->course_code }}</span>
                                <span class="text-slate-500">{{ $routine->course_name }}</span>
                                <span>Day: {{ $routine->day }}</span>
                                <span>Slot: {{ $routine->time_slot }}</span>
                            </div>
                            <form method="POST" action="{{ route('admin.exam-routines.delete', $routine) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600"><span class="material-symbols-outlined font-black">delete</span></button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- 3. Section Routine Panel -->
            <section id="admin-tab-section" class="admin-panel hidden bg-white border-2 border-slate-200 rounded-[2.5rem] p-8 shadow-sm">
                <h2 class="text-2xl font-[900] text-[#003366] mb-6 uppercase tracking-tight">Section Routine</h2>
                <!-- Simplified display for brevity -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-bold">
                        <thead>
                            <tr class="text-[10px] text-slate-400 uppercase tracking-widest border-b-2 border-slate-100">
                                <th class="pb-4">Code</th>
                                <th class="pb-4">Section</th>
                                <th class="pb-4">Time</th>
                                <th class="pb-4">Faculty</th>
                                <th class="pb-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            @foreach ($sectionRoutines as $routine)
                            <tr>
                                <td class="py-4">{{ $routine->course_code }}</td>
                                <td class="py-4">{{ $routine->section }}</td>
                                <td class="py-4">{{ substr($routine->start_time, 0, 5) }} - {{ substr($routine->end_time, 0, 5) }}</td>
                                <td class="py-4 text-slate-500">{{ $routine->faculty_name }}</td>
                                <td class="py-4 text-right">
                                    <form method="POST" action="{{ route('admin.section-routines.delete', $routine) }}">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-600"><span class="material-symbols-outlined font-black text-xl">delete</span></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- NEW: 4. Manage Links Panel -->
            <section id="admin-tab-links" class="admin-panel hidden bg-white border-2 border-slate-200 rounded-[2.5rem] p-10 shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-[900] text-[#003366] uppercase tracking-tighter">Academic Class Links</h2>
                    <span class="bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-xs font-black tracking-widest uppercase">
                        {{ $classLinks->count() }} Total Submissions
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-[900] text-slate-400 uppercase tracking-[0.2em] border-b-4 border-slate-50">
                                <th class="pb-6 px-4">Course</th>
                                <th class="pb-6 px-4">Section</th>
                                <th class="pb-6 px-4">Type</th>
                                <th class="pb-6 px-4">Source URL</th>
                                <th class="pb-6 px-4">By Student</th>
                                <th class="pb-6 px-4 text-right">Management</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-slate-50 font-black text-sm text-slate-700">
                            @forelse ($classLinks as $link)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-6 px-4 text-[#003366] uppercase">{{ $link->course_code }}</td>
                                <td class="py-6 px-4"><span class="bg-slate-100 px-3 py-1 rounded-lg">{{ $link->section }}</span></td>
                                <td class="py-6 px-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] {{ $link->link_type === 'live' ? 'bg-red-50 text-red-600' : 'bg-indigo-50 text-indigo-600' }}">
                                        {{ strtoupper($link->link_type) }}
                                    </span>
                                </td>
                                <td class="py-6 px-4">
                                    <a href="{{ $link->url }}" target="_blank" class="text-blue-500 underline truncate block max-w-xs hover:text-blue-800 transition-colors">
                                        {{ $link->url }}
                                    </a>
                                </td>
                                <td class="py-6 px-4 text-slate-400">{{ $link->user->username ?? 'Unknown' }}</td>
                                <td class="py-6 px-4 text-right">
                                    <form method="POST" action="{{ route('admin.links.delete', $link) }}" onsubmit="return confirm('Remove this class link?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-50 text-red-600 px-4 py-2 rounded-xl text-[10px] font-black hover:bg-red-600 hover:text-white transition-all">
                                            DELETE
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center text-slate-300 italic font-bold">No class links submitted yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 5. Reports Panel -->
            <section id="admin-tab-reports" class="admin-panel hidden bg-white border-2 border-slate-200 rounded-[2.5rem] p-8 shadow-sm">
                <h2 class="text-2xl font-[900] text-[#003366] mb-6 uppercase">Reported Messages</h2>
                <div class="space-y-4">
                    @forelse ($reportedMessages as $message)
                        <div class="border-2 border-slate-100 rounded-2xl p-6 bg-slate-50/30">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                        {{ $message->group->name ?? 'System' }} • Reported by {{ $message->reportedBy->username }}
                                    </p>
                                    <p class="font-black text-slate-900">{{ $message->user->username ?? 'Deleted' }}</p>
                                    <p class="text-slate-600 mt-1">{{ $message->message }}</p>
                                    <p class="text-xs font-bold text-red-400 mt-2 italic">Reason: {{ $message->report_reason }}</p>
                                </div>
                                <form method="POST" action="{{ $message->user->banned_at ? route('admin.users.unban', $message->user) : route('admin.users.ban', $message->user) }}">
                                    @csrf @method('PATCH')
                                    <button class="rounded-xl px-6 py-3 text-xs font-black transition-all {{ $message->user->banned_at ? 'bg-green-600 text-white' : 'bg-red-700 text-white shadow-lg' }}">
                                        {{ $message->user->banned_at ? 'UNBAN USER' : 'BAN USER' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 italic">No reports found.</p>
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
        // Updated allowed tabs list
        if (['groups', 'exam', 'section', 'reports', 'links'].includes(initialTab)) {
            activateAdminTab(initialTab);
        }
    </script>
</body>
</html>