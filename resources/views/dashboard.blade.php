<x-layout>
    <x-slot:title>Workspace | CampusConnect</x-slot:title>

    <main class="pt-20 md:pt-28 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12"> 

            <!-- ============================================================
                 SECTION 1: HEADER (Responsive Typography)
                 ============================================================ -->
            <div class="flex flex-col lg:flex-row justify-between items-center mb-10 md:mb-16 gap-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-[900] text-[#003366] tracking-tight mb-3 uppercase">University Workspace</h1>
                    <div class="flex items-center justify-center lg:justify-start gap-3">
                        <span class="hidden sm:block h-1.5 w-10 bg-blue-600 rounded-full"></span>
                        <p class="text-slate-500 font-[900] italic text-lg md:text-xl lg:text-2xl uppercase tracking-tighter">
                            "Hello {{ Auth::user()->username }}, stay organized and productive."
                        </p>
                    </div>
                </div>

                <!-- Live Clock & Weather Widget -->
                <div class="flex flex-wrap justify-center items-center gap-4 md:gap-8 bg-white p-3 md:pl-10 rounded-[2.5rem] md:rounded-[3.5rem] shadow-md border border-slate-100 w-full lg:w-auto">
                    <div class="text-center md:text-right border-r-0 md:border-r pr-0 md:pr-8 border-slate-100">
                        <p id="live-clock" class="text-3xl md:text-4xl lg:text-5xl font-[900] text-[#003366] tabular-nums tracking-tighter">00:00:00</p>
                        <p class="text-[10px] uppercase text-slate-400 font-black tracking-widest">Dhaka Time</p>
                    </div>
                    <div class="flex items-center gap-4 bg-slate-50 py-3 md:py-4 px-6 md:px-8 rounded-[2rem] md:rounded-[2.5rem]">
                        <span class="material-symbols-outlined text-orange-400 text-4xl md:text-5xl">wb_sunny</span>
                        <div class="leading-tight">
                            <p class="text-2xl md:text-3xl font-[900] text-slate-800">{{ $weather['temp'] }}°C</p>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $weather['desc'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================
                 SECTION 2: MAIN BENTO GRID (7:5 Ratio)
                 ============================================================ -->
            <div class="grid grid-cols-12 gap-6 md:gap-10">

                <!-- ── LEFT COLUMN: TO DO LIST (Responsive) ── -->
                <div class="col-span-12 lg:col-span-7 bg-white rounded-[2.5rem] md:rounded-[3.5rem] border border-slate-100 shadow-[0_30px_60px_-20px_rgba(0,0,0,0.05)] p-6 md:p-14">
                    
                    <div class="mb-10">
                        <h3 class="text-3xl md:text-4xl font-[900] text-[#003366] flex items-center gap-4 uppercase mb-8">
                            <span class="material-symbols-outlined text-4xl font-black text-blue-600">checklist</span> To Do List
                        </h3>

                        <!-- Add Task Form -->
                        <form action="{{ route('tasks.store') }}" method="POST" class="w-full bg-slate-50 rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-8 border-2 border-slate-100 shadow-inner space-y-6">
                            @csrf
                            <div class="space-y-4">
                                <input type="text" name="title" placeholder="What needs to be done?" class="w-full bg-transparent border-b-2 md:border-b-4 border-slate-200 focus:border-blue-600 p-2 font-[900] text-xl md:text-3xl outline-none text-slate-800 placeholder:text-slate-300" required>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-6 items-center md:items-end">
                                <div class="flex-1 w-full">
                                    <label class="block text-[10px] font-black uppercase text-slate-400 ml-2 mb-2 tracking-widest">Set Deadline</label>
                                    <input type="date" name="due_date" class="w-full bg-white border-2 border-slate-100 rounded-2xl p-4 font-[900] text-slate-700 outline-none focus:border-blue-400">
                                </div>
                                <button type="submit" class="w-full md:w-auto bg-[#003366] text-white px-10 md:px-12 py-4 md:py-5 rounded-2xl font-[900] uppercase tracking-widest text-xs shadow-lg hover:bg-blue-800 transition-all hover:-translate-y-1">
                                    + ADD TASK
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Task Items -->
                    <div class="space-y-6">
                        <p class="text-xs font-black text-blue-500 uppercase tracking-[0.4em] ml-4 mb-6">Active Tasks</p>
                        @forelse($pendingTasks as $task)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 md:p-8 bg-white rounded-[2rem] md:rounded-[3rem] border border-slate-100 hover:border-blue-300 hover:shadow-2xl transition-all group gap-6">
                                <div class="flex items-start gap-6">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-10 h-10 md:w-12 md:h-12 border-4 border-slate-200 rounded-2xl hover:bg-blue-600 transition-all flex items-center justify-center"></button>
                                    </form>
                                    <div>
                                        <h4 class="font-[900] text-xl md:text-3xl tracking-tight text-slate-800">{{ $task->title }}</h4>
                                        <div class="flex flex-wrap gap-2 md:gap-4 mt-3">
                                            <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase bg-slate-100 px-3 py-1.5 rounded-full">Added: {{ $task->created_at->format('M d, Y') }}</span>
                                            @if($task->due_date)
                                                <span class="text-[9px] md:text-[10px] font-black text-orange-600 uppercase bg-orange-50 px-3 py-1.5 rounded-full border border-orange-100">Due: {{ $task->due_date->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="material-symbols-outlined text-slate-200 hover:text-red-500 transition-colors text-3xl md:text-4xl font-black">delete</button>
                                </form>
                            </div>
                        @empty
                            <div class="py-16 md:py-24 text-center border-4 border-dashed border-slate-50 rounded-[3rem] md:rounded-[4rem]">
                                <p class="text-slate-400 font-black italic text-xl md:text-3xl uppercase tracking-tighter">Your list is empty! ☕</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- History / Accomplished -->
                    @if($completedTasks->count() > 0)
                    <div class="pt-10 mt-12 border-t-4 border-slate-50 space-y-6">
                        <p class="text-xs font-black text-slate-300 uppercase tracking-[0.4em] ml-4 mb-6">Completed Tasks</p>
                        @foreach($completedTasks as $task)
                            <div class="flex items-center justify-between p-5 bg-slate-50/50 rounded-[2rem] opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
                                <div class="flex items-center gap-6">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-white text-lg font-black">done</span>
                                        </button>
                                    </form>
                                    <span class="font-bold text-slate-500 line-through text-lg md:text-2xl tracking-tight">{{ $task->title }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- ── RIGHT COLUMN: CALENDAR (Fixed for all monitors) ── -->
                <div class="col-span-12 lg:col-span-5 bg-white rounded-[2.5rem] md:rounded-[3.5rem] border border-slate-100 shadow-[0_30px_60px_-20px_rgba(0,0,0,0.05)] p-6 md:p-12 flex flex-col">
                    <div class="flex justify-between items-center mb-10 md:mb-12">
                        <h4 id="cal-month-label" class="font-[900] text-2xl md:text-3xl text-slate-800 uppercase tracking-tighter">Month</h4>
                        <div class="flex gap-2">
                            <button id="cal-prev" class="w-10 h-10 md:w-14 md:h-14 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 transition-all"><span class="material-symbols-outlined text-3xl md:text-4xl font-black">chevron_left</span></button>
                            <button id="cal-next" class="w-10 h-10 md:w-14 md:h-14 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 transition-all"><span class="material-symbols-outlined text-3xl md:text-4xl font-black">chevron_right</span></button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 md:gap-2 text-center text-[10px] md:text-xs font-[900] text-slate-300 mb-8 md:mb-10 tracking-widest uppercase">
                        <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                    </div>

                    <div id="cal-grid" class="grid grid-cols-7 gap-y-4 md:gap-y-8 gap-x-1 md:gap-x-2 text-center min-h-[300px] md:min-h-[400px]"></div>

                    <div class="mt-auto pt-8 border-t-2 md:border-t-4 border-slate-50">
                        @if($upcomingExam)
                            <div class="flex items-center gap-4 p-6 bg-red-50 rounded-[2rem] border border-red-100">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-ping"></div>
                                <p class="text-sm md:text-lg font-[900] text-red-600 uppercase tracking-widest">Exam: {{ $upcomingExam->name }}</p>
                            </div>
                        @else
                            <div class="text-center opacity-30">
                                <p class="text-[10px] md:text-xs font-[900] text-slate-400 uppercase tracking-[0.5em]">No Upcoming Exams</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <footer class="mt-16 md:mt-20 text-center border-t-2 md:border-t-4 border-slate-50 pt-8 md:pt-12 pb-6">
                <p class="text-slate-300 text-[10px] md:text-sm font-black uppercase tracking-[0.6em] md:tracking-[0.8em]">Pipeline Mechanics // Unified Student Ecosystem</p>
            </footer>
        </div>
    </main>

    <!-- Calendar Script (Previous working logic) -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const clock = document.getElementById('live-clock');
        function updateClock() { clock.innerText = new Date().toLocaleTimeString('en-US', {hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit'}); }
        setInterval(updateClock, 1000); updateClock();

        const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const today = new Date(); let vYear = today.getFullYear(), vMonth = today.getMonth();
        
        function renderCalendar() {
            const label = document.getElementById('cal-month-label'), grid = document.getElementById('cal-grid');
            label.textContent = `${MONTHS[vMonth]} ${vYear}`; grid.innerHTML = '';
            const firstDay = new Date(vYear, vMonth, 1).getDay(), daysInMonth = new Date(vYear, vMonth+1, 0).getDate();
            for (let i = 0; i < firstDay; i++) grid.appendChild(document.createElement('div'));
            for (let day = 1; day <= daysInMonth; day++) {
                const dayBox = document.createElement('div'); dayBox.className = 'flex justify-center items-center';
                const isToday = (vYear === today.getFullYear() && vMonth === today.getMonth() && day === today.getDate());
                const span = document.createElement('span'); span.textContent = day;
                span.className = isToday 
                    ? 'w-10 h-10 md:w-14 md:h-14 flex items-center justify-center text-base md:text-xl font-[900] rounded-xl md:rounded-2xl bg-blue-600 text-white shadow-2xl scale-110' 
                    : 'w-10 h-10 md:w-14 md:h-14 flex items-center justify-center text-base md:text-xl font-black rounded-xl md:rounded-2xl text-slate-600 hover:bg-slate-50 cursor-pointer transition-all';
                dayBox.appendChild(span); grid.appendChild(dayBox);
            }
        }
        document.getElementById('cal-prev').onclick = () => { vMonth--; if(vMonth<0){vMonth=11; vYear--;} renderCalendar(); };
        document.getElementById('cal-next').onclick = () => { vMonth++; if(vMonth>11){vMonth=0; vYear++;} renderCalendar(); };
        renderCalendar();
    });
    </script>
</x-layout>