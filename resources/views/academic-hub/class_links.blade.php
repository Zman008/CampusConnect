<x-layout>
    <x-slot:title>Class Links Hub | CampusConnect</x-slot:title>

    <main class="pt-28 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1600px] mx-auto px-6 md:px-12">
            
            <!-- SECTION 1: HEADER & SEARCH -->
            <div class="flex flex-col lg:flex-row justify-between items-center mb-16 gap-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-6xl font-[900] text-[#003366] tracking-tight mb-3 uppercase">Academic Hub</h1>
                    <p class="text-slate-500 font-black italic text-2xl uppercase tracking-tighter text-blue-600">
                        "Real-time Class Links & Session Recordings"
                    </p>
                </div>

                <!-- LIVE SEARCH BAR -->
                <div class="w-full lg:w-1/3 relative group">
                    <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors text-3xl">search</span>
                    <input type="text" id="courseSearch" placeholder="Search by name or course ID..." 
                           class="w-full bg-white border-4 border-slate-100 rounded-[2.5rem] py-6 pl-20 pr-8 font-[900] text-2xl text-[#003366] shadow-md focus:ring-8 focus:ring-blue-50 outline-none transition-all placeholder:text-slate-300">
                </div>
            </div>

            <div class="grid grid-cols-12 gap-10">
                
                <!-- ── LEFT: COURSE GRID (8 Columns) ── -->
                <div class="col-span-12 lg:col-span-8">
                    <div id="courseGrid" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($courses as $course)
                        <div class="course-card bg-white rounded-[4rem] border-2 border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] p-10 hover:border-blue-400 hover:shadow-2xl transition-all group relative overflow-hidden" 
                             data-name="{{ strtolower($course['name']) }}" data-id="{{ strtolower($course['id']) }}">
                            
                            <span class="inline-block px-6 py-2 bg-blue-50 text-blue-700 text-sm font-[900] rounded-full tracking-widest uppercase mb-8 border-2 border-blue-100">
                                {{ $course['id'] }}
                            </span>

                            <h3 class="text-4xl font-[900] text-[#003366] mb-10 leading-tight h-32 overflow-hidden line-clamp-2 uppercase">
                                {{ $course['name'] }}
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Live Class Button (Opens Section Modal) -->
                                <button onclick="openSectionModal('{{ $course['id'] }}', 'live')" class="flex items-center justify-center gap-3 bg-slate-50 text-[#003366] py-6 rounded-[2rem] font-[900] text-sm tracking-widest hover:bg-blue-600 hover:text-white transition-all uppercase shadow-sm">
                                    <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                                    Live Class
                                </button>

                                <!-- Recording Button -->
                                <a href="{{ $course['playlist'] }}" target="_blank" class="flex items-center justify-center gap-3 bg-[#003366] text-white py-6 rounded-[2rem] font-[900] text-sm tracking-widest hover:bg-blue-800 shadow-xl transition-all uppercase">
                                    <span class="material-symbols-outlined text-2xl">play_circle</span>
                                    Recordings
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- No Results Placeholder -->
                    <div id="noResults" class="hidden py-32 text-center bg-white rounded-[4rem] border-4 border-dashed border-slate-100">
                        <span class="material-symbols-outlined text-9xl text-slate-200 mb-6">search_off</span>
                        <h4 class="text-4xl font-[900] text-slate-300 uppercase tracking-tighter">No matching courses found.</h4>
                    </div>
                </div>

                <!-- ── RIGHT: SUBMISSION FORM (4 Columns) ── -->
                <div class="col-span-12 lg:col-span-4">
                    <div class="bg-[#001529] rounded-[4rem] p-12 sticky top-28 shadow-2xl border-4 border-blue-900/30 overflow-hidden relative">
                        <div class="relative z-10">
                            <h3 class="text-3xl font-[900] text-white mb-2 uppercase tracking-tighter">Contribute</h3>
                            <p class="text-blue-400 font-bold text-sm uppercase tracking-widest mb-10">Share a Live or Recording Link</p>

                            @if(session('success'))
                                <div class="mb-8 p-4 bg-green-500/10 border-2 border-green-500/20 text-green-400 font-black rounded-2xl text-xs uppercase tracking-widest">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('class.links.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <!-- Course Selection -->
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 ml-2">Select Course</label>
                                    <select name="course_code" required class="w-full bg-white/5 border-2 border-white/10 rounded-2xl p-5 text-white font-black text-lg outline-none focus:border-blue-500 transition-all">
                                        @foreach($courses as $c)
                                            <option value="{{ $c['id'] }}" class="bg-[#001529]">{{ $c['id'] }} - {{ $c['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Section -->
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 ml-2">Section</label>
                                        <input type="text" name="section" placeholder="e.g. A" required class="w-full bg-white/5 border-2 border-white/10 rounded-2xl p-5 text-white font-black text-lg outline-none focus:border-blue-500 transition-all uppercase">
                                    </div>
                                    <!-- Type -->
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 ml-2">Link Type</label>
                                        <select name="link_type" class="w-full bg-white/5 border-2 border-white/10 rounded-2xl p-5 text-white font-black text-lg outline-none focus:border-blue-500 transition-all">
                                            <option value="live" class="bg-[#001529]">Live</option>
                                            <option value="recording" class="bg-[#001529]">Recording</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- URL -->
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 ml-2">Paste URL</label>
                                    <input type="url" name="url" placeholder="https://..." required class="w-full bg-white/5 border-2 border-white/10 rounded-2xl p-5 text-white font-black text-lg outline-none focus:border-blue-500 transition-all">
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white py-6 rounded-[2rem] font-[900] uppercase tracking-[0.2em] text-xs shadow-xl hover:bg-blue-500 hover:-translate-y-1 transition-all">
                                    Submit Link
                                </button>
                            </form>
                        </div>
                        <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl"></div>
                    </div>
                </div>
            </div>

            <!-- SECTION SELECTION MODAL -->
            <div id="sectionModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[#001529]/80 backdrop-blur-md p-6">
                <div class="bg-white w-full max-w-3xl rounded-[4rem] p-16 shadow-2xl relative border-4 border-slate-50">
                    <button onclick="closeSectionModal()" class="absolute top-10 right-10 text-slate-300 hover:text-red-500 transition-all">
                        <span class="material-symbols-outlined text-5xl font-black">close</span>
                    </button>
                    
                    <h2 id="modalTitle" class="text-5xl font-[900] text-[#003366] mb-4 uppercase tracking-tighter">Select Section</h2>
                    <p id="modalCourseId" class="text-blue-600 font-black text-xl uppercase tracking-[0.4em] mb-12">MATH 1151</p>

                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-6" id="sectionGrid">
                        @foreach(range('A', 'R') as $char) <!-- UIU Sections often go up to R or more -->
                            <button onclick="checkLink('{{ $char }}')" class="w-full aspect-square flex items-center justify-center bg-slate-50 rounded-[2rem] text-3xl font-[900] text-slate-400 hover:bg-[#003366] hover:text-white hover:scale-110 transition-all border-4 border-transparent shadow-sm">
                                {{ $char }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Warning Message -->
                    <div id="statusMessage" class="hidden mt-12 p-8 bg-red-50 rounded-[2.5rem] border-4 border-red-100 text-center animate-bounce">
                        <p class="text-red-600 font-[900] uppercase tracking-widest text-lg">⚠️ No active link found for this section.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        let activeCourse = '';
        let activeType = '';
        const dbLinks = @json($dbLinks); // Passing DB data to Javascript

        /**
         * Opens the section selection modal
         */
        function openSectionModal(courseId, type) {
            activeCourse = courseId;
            activeType = type;
            document.getElementById('modalCourseId').innerText = courseId;
            document.getElementById('sectionModal').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('hidden');
        }

        /**
         * Closes the section selection modal
         */
        function closeSectionModal() {
            document.getElementById('sectionModal').classList.add('hidden');
        }

        /**
         * Checks if a link exists in the database for the selected section
         */
        function checkLink(section) {
            const match = dbLinks.find(l => 
                l.course_code === activeCourse && 
                l.section === section && 
                l.link_type === activeType
            );

            if (match) {
                window.open(match.url, '_blank');
            } else {
                const msg = document.getElementById('statusMessage');
                msg.classList.remove('hidden');
                setTimeout(() => msg.classList.add('hidden'), 3000);
            }
        }

        /**
         * Real-time search filter for courses
         */
        document.getElementById('courseSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.course-card');
            let found = 0;

            cards.forEach(card => {
                const isMatch = card.dataset.name.includes(term) || card.dataset.id.includes(term);
                card.classList.toggle('hidden', !isMatch);
                if (isMatch) found++;
            });

            document.getElementById('noResults').classList.toggle('hidden', found > 0);
            document.getElementById('courseGrid').classList.toggle('hidden', found === 0);
        });
    </script>
</x-layout>