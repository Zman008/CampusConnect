<x-layout>
    <x-slot:title>Workspace | CampusConnect</x-slot:title>

    <main class="pt-24 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1400px] mx-auto px-4 md:px-10">

            <!-- HEADER SECTION -->
            <div class="flex flex-col lg:flex-row justify-between items-center mb-12 gap-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl font-extrabold text-[#003366] tracking-tight mb-2">University Workspace</h1>
                    <p class="text-slate-500 font-semibold italic text-lg">"Hello {{ Auth::user()->username }}, focus on your goals."</p>
                </div>

                <!-- Live Clock & Weather -->
                <div class="flex items-center gap-6 bg-white p-2 pl-8 rounded-[3rem] shadow-sm border border-slate-100">
                    <div class="text-right border-r pr-6 border-slate-100">
                        <p id="live-clock" class="text-3xl font-black text-[#003366] tabular-nums">00:00:00</p>
                        <p class="text-[10px] uppercase text-slate-400 font-bold">Dhaka Time</p>
                    </div>
                    <div class="flex items-center gap-4 bg-slate-50 py-3 px-6 rounded-[2.5rem]">
                        <span class="material-symbols-outlined text-orange-400 text-4xl">wb_sunny</span>
                        <div class="leading-tight">
                            <p class="text-2xl font-black text-slate-800">{{ $weather['temp'] }}°C</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $weather['desc'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN GRID (8:4) -->
            <div class="grid grid-cols-12 gap-8">

                <!-- LEFT: TASK MANAGER (8 Cols) -->
                <div class="col-span-12 lg:col-span-8 bg-white rounded-[3rem] border border-slate-100 shadow-xl p-8 md:p-10">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-10 gap-6">
                        <h3 class="text-2xl font-black text-[#003366] flex items-center gap-3">
                            <span class="material-symbols-outlined text-3xl">task_alt</span> Daily Missions
                        </h3>

                        <form action="{{ route('tasks.store') }}" method="POST" class="flex w-full sm:w-auto bg-slate-50 rounded-2xl p-1.5 border border-slate-200">
                            @csrf
                            <input type="text" name="title" placeholder="New mission..." class="bg-transparent border-none px-5 py-2 text-sm focus:ring-0 w-full sm:w-60 text-slate-700 font-bold" required>
                            <button type="submit" class="bg-[#003366] text-white px-6 py-2 rounded-xl text-xs font-black">ADD</button>
                        </form>
                    </div>

                    <!-- Pending Tasks -->
                    <div class="space-y-4 mb-10">
                        @forelse($pendingTasks as $task)
                            <div class="flex items-center justify-between p-5 bg-white rounded-[2rem] border border-slate-100 hover:border-blue-200 transition-all group">
                                <div class="flex items-center gap-5">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-8 h-8 border-2 border-slate-200 rounded-xl hover:bg-blue-600 transition-all"></button>
                                    </form>
                                    <span class="font-bold text-slate-700 text-lg">{{ $task->title }}</span>
                                </div>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Remove?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="material-symbols-outlined text-slate-200 hover:text-red-500 transition-colors">delete</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-center py-10 text-slate-400 italic">No active missions! ☕</p>
                        @endforelse
                    </div>

                    <!-- Completed Tasks -->
                    @if($completedTasks->count() > 0)
                    <div class="pt-8 border-t border-slate-100 space-y-3">
                        <p class="text-[11px] font-black text-slate-300 uppercase tracking-widest ml-2 mb-4">Completed</p>
                        @foreach($completedTasks as $task)
                            <div class="flex items-center justify-between p-4 bg-slate-50/50 rounded-[1.5rem] opacity-60">
                                <div class="flex items-center gap-5">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center">
                                            <span class="material-symbols-outlined text-white text-sm">done</span>
                                        </button>
                                    </form>
                                    <span class="font-bold text-slate-400 line-through">{{ $task->title }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- RIGHT: CALENDAR (4 Cols) -->
                <div class="col-span-12 lg:col-span-4 flex flex-col gap-8">
                    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl p-8">
                        <div class="flex justify-between items-center mb-8">
                            <h4 id="cal-month-label" class="font-black text-slate-800 text-xl uppercase tracking-tighter">Month</h4>
                            <div class="flex gap-1">
                                <button id="cal-prev" class="w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined">chevron_left</span>
                                </button>
                                <button id="cal-next" class="w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </button>
                            </div>
                        </div>

                        <!-- Days Header -->
                        <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-black text-slate-300 mb-6">
                            <span>S</span><span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                        </div>

                        <!-- Grid Container (Fixed the 7 columns here) -->
                        <div id="cal-grid" class="grid grid-cols-7 gap-y-3 gap-x-1 text-center min-h-[240px]">
                            <!-- Filled by JS -->
                        </div>
                    </div>

                    <!-- Engine Status -->
                    <div class="p-8 bg-[#001529] rounded-[3rem] shadow-2xl relative overflow-hidden">
                        <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.4em] mb-1">Status</p>
                        <h4 class="text-white text-2xl font-bold tracking-tight">CampusConnect <span class="text-[10px] text-slate-500">v1.1.2</span></h4>
                        <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden mt-4">
                            <div class="bg-blue-500 h-full w-[85%] rounded-full"></div>
                        </div>
                        <p class="text-slate-500 text-[10px] font-black mt-2 text-right">Sprint 1: 85%</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-16 text-center border-t border-slate-100 pt-8">
                <p class="text-slate-300 text-[10px] font-black uppercase tracking-[0.5em]">Pipeline Mechanics // Unified Student Ecosystem</p>
            </footer>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Live Clock
        const clock = document.getElementById('live-clock');
        function updateClock() {
            clock.innerText = new Date().toLocaleTimeString('en-US', {
                hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
        setInterval(updateClock, 1000); updateClock();

        // Calendar
        const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const today = new Date();
        let viewYear = today.getFullYear();
        let viewMonth = today.getMonth();

        function renderCalendar() {
            const label = document.getElementById('cal-month-label');
            const grid = document.getElementById('cal-grid');
            label.textContent = `${MONTHS[viewMonth]} ${viewYear}`;
            grid.innerHTML = '';

            const firstDay = new Date(viewYear, viewMonth, 1).getDay();
            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                grid.appendChild(document.createElement('div'));
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayBox = document.createElement('div');
                dayBox.className = 'flex justify-center items-center';
                const isToday = (viewYear === today.getFullYear() && viewMonth === today.getMonth() && day === today.getDate());
                
                const span = document.createElement('span');
                span.textContent = day;
                span.className = isToday 
                    ? 'w-9 h-9 flex items-center justify-center text-xs font-black rounded-xl bg-blue-600 text-white shadow-lg'
                    : 'w-9 h-9 flex items-center justify-center text-xs font-bold rounded-xl text-slate-500 hover:bg-slate-50 cursor-pointer transition-all';
                
                dayBox.appendChild(span);
                grid.appendChild(dayBox);
            }
        }

        document.getElementById('cal-prev').onclick = () => { viewMonth--; if(viewMonth<0){viewMonth=11; viewYear--;} renderCalendar(); };
        document.getElementById('cal-next').onclick = () => { viewMonth++; if(viewMonth>11){viewMonth=0; viewYear++;} renderCalendar(); };
        renderCalendar();
    });
    </script>
</x-layout>