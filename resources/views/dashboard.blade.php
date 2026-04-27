<x-layout>
    <x-slot:title>Workspace | CampusConnect</x-slot:title>

    <main class="pt-28 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1600px] mx-auto px-6 md:px-12"> <!-- Container width increased for large monitors -->

            <!-- ============================================================
                 SECTION 1: HEADER (Scaled up for Large Screens)
                 ============================================================ -->
            <div class="flex flex-col lg:flex-row justify-between items-center mb-16 gap-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-5xl lg:text-6xl font-black text-[#003366] tracking-tight mb-3">University Workspace</h1>
                    <div class="flex items-center justify-center lg:justify-start gap-3">
                        <span class="h-1.5 w-10 bg-blue-600 rounded-full"></span>
                        <p class="text-slate-500 font-bold italic text-xl lg:text-2xl">
                            "Hello {{ Auth::user()->username }}, focus on your goals."
                        </p>
                    </div>
                </div>

                <!-- Live Clock & Weather Widget (Bigger for readability) -->
                <div class="flex items-center gap-8 bg-white p-3 pl-10 rounded-[3.5rem] shadow-md border border-slate-100">
                    <div class="text-right border-r pr-8 border-slate-100">
                        <p id="live-clock" class="text-4xl lg:text-5xl font-black text-[#003366] tabular-nums tracking-tighter">00:00:00</p>
                        <p class="text-xs uppercase text-slate-400 font-black tracking-widest">Dhaka Time</p>
                    </div>
                    <div class="flex items-center gap-6 bg-slate-50 py-4 px-8 rounded-[2.5rem]">
                        <span class="material-symbols-outlined text-orange-400 text-5xl">wb_sunny</span>
                        <div class="leading-tight">
                            <p class="text-3xl font-black text-slate-800">{{ $weather['temp'] }}°C</p>
                            <p class="text-xs text-slate-400 font-black uppercase tracking-[0.2em]">{{ $weather['desc'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================
                 SECTION 2: MAIN BALANCED BENTO GRID (7:5 Ratio)
                 ============================================================ -->
            <div class="grid grid-cols-12 gap-10">

                <!-- ── LEFT COLUMN: TASK MANAGER ── -->
                <div class="col-span-12 lg:col-span-7 bg-white rounded-[3.5rem] border border-slate-100 shadow-[0_30px_60px_-20px_rgba(0,0,0,0.05)] p-10 md:p-14">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-8">
                        <h3 class="text-3xl font-black text-[#003366] flex items-center gap-4">
                            <span class="material-symbols-outlined text-4xl font-bold text-blue-600">task_alt</span> Daily Missions
                        </h3>

                        <!-- Add Task Form (Wider Input) -->
                        <form action="{{ route('tasks.store') }}" method="POST" class="flex w-full sm:w-auto bg-slate-50 rounded-[1.5rem] p-2 border border-slate-200 focus-within:ring-4 focus-within:ring-blue-100 transition-all">
                            @csrf
                            <input type="text" name="title" placeholder="New mission..." class="bg-transparent border-none px-6 py-3 text-lg focus:ring-0 w-full sm:w-64 text-slate-700 font-bold" required>
                            <button type="submit" class="bg-[#003366] text-white px-8 py-3 rounded-2xl text-sm font-black hover:bg-blue-800 transition-all shadow-lg">ADD</button>
                        </form>
                    </div>

                    <!-- Pending Tasks -->
                    <div class="space-y-6 mb-12">
                        @forelse($pendingTasks as $task)
                            <div class="flex items-center justify-between p-6 bg-white rounded-[2.5rem] border border-slate-100 hover:border-blue-200 hover:shadow-2xl hover:shadow-blue-900/5 transition-all group">
                                <div class="flex items-center gap-6">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-10 h-10 border-2 border-slate-200 rounded-2xl hover:bg-blue-600 transition-all flex items-center justify-center"></button>
                                    </form>
                                    <span class="font-extrabold text-slate-800 text-xl lg:text-2xl tracking-tight">{{ $task->title }}</span>
                                </div>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Remove this mission?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="material-symbols-outlined text-slate-300 hover:text-red-500 transition-colors text-3xl">delete</button>
                                </form>
                            </div>
                        @empty
                            <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[3rem] bg-slate-50/20">
                                <p class="text-slate-400 font-black italic text-xl">No active missions! ☕</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Completed Tasks -->
                    @if($completedTasks->count() > 0)
                    <div class="pt-10 border-t border-slate-100 space-y-4">
                        <p class="text-xs font-black text-slate-300 uppercase tracking-[0.4em] ml-4 mb-6">Accomplished</p>
                        @foreach($completedTasks as $task)
                            <div class="flex items-center justify-between p-5 bg-slate-50/50 rounded-[2rem] opacity-60 hover:opacity-100 transition-opacity">
                                <div class="flex items-center gap-6">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                            <span class="material-symbols-outlined text-white text-lg font-black">done</span>
                                        </button>
                                    </form>
                                    <span class="font-bold text-slate-400 line-through text-lg lg:text-xl">{{ $task->title }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- ── RIGHT COLUMN: CALENDAR (Bigger cells) ── -->
                <div class="col-span-12 lg:col-span-5 bg-white rounded-[3.5rem] border border-slate-100 shadow-[0_30px_60px_-20px_rgba(0,0,0,0.05)] p-10 md:p-12 flex flex-col">
                    <div class="flex justify-between items-center mb-12">
                        <h4 id="cal-month-label" class="font-black text-slate-800 text-2xl lg:text-3xl uppercase tracking-tighter">Month</h4>
                        <div class="flex gap-2">
                            <button id="cal-prev" class="w-12 h-12 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 transition-all">
                                <span class="material-symbols-outlined text-3xl">chevron_left</span>
                            </button>
                            <button id="cal-next" class="w-12 h-12 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 transition-all">
                                <span class="material-symbols-outlined text-3xl">chevron_right</span>
                            </button>
                        </div>
                    </div>

                    <!-- Days Header -->
                    <div class="grid grid-cols-7 gap-2 text-center text-xs font-black text-slate-300 mb-8 tracking-widest">
                        <span>SUN</span><span>MON</span><span>TUE</span><span>WED</span><span>THU</span><span>FRI</span><span>SAT</span>
                    </div>

                    <!-- Grid Container (Increased min-height) -->
                    <div id="cal-grid" class="grid grid-cols-7 gap-y-6 gap-x-2 text-center min-h-[350px]">
                        <!-- Filled by JS -->
                    </div>

                    <!-- Exam Indicator -->
                    <div class="mt-auto pt-10 border-t border-slate-50">
                        @if($upcomingExam)
                            <div class="flex items-center gap-4 p-6 bg-red-50 rounded-[2rem] border border-red-100">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-ping"></div>
                                <p class="text-sm font-black text-red-600 uppercase tracking-widest">Exam: {{ $upcomingExam->name }}</p>
                            </div>
                        @else
                            <div class="flex items-center justify-center gap-4 opacity-30">
                                <p class="text-xs font-black text-slate-400 uppercase tracking-[0.5em]">No Upcoming Exams</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <footer class="mt-20 text-center border-t border-slate-100 pt-10">
                <p class="text-slate-300 text-xs font-black uppercase tracking-[0.6em]">Pipeline Mechanics // Unified Student Ecosystem</p>
            </footer>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Live Clock (Updated for 2-digit sizing)
        const clock = document.getElementById('live-clock');
        function updateClock() {
            clock.innerText = new Date().toLocaleTimeString('en-US', {
                hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
        setInterval(updateClock, 1000); updateClock();

        // Calendar Logic (No changes needed for JS, just CSS classes below)
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
                // Font size increased here: text-sm to text-lg
                span.className = isToday 
                    ? 'w-12 h-12 flex items-center justify-center text-lg font-black rounded-2xl bg-blue-600 text-white shadow-2xl shadow-blue-400 scale-110'
                    : 'w-12 h-12 flex items-center justify-center text-lg font-bold rounded-2xl text-slate-600 hover:bg-slate-50 cursor-pointer transition-all';
                
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