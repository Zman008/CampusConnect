<x-layout>
    <x-slot:title>CGPA Calculator | CampusConnect</x-slot:title>

    <main class="pt-28 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12">
            
            <!-- HEADER -->
            <div class="mb-12 text-center lg:text-left">
                <h1 class="text-5xl font-black text-[#003366] tracking-tight mb-2">CGPA Calculator</h1>
                <p class="text-slate-500 font-bold italic text-xl uppercase tracking-tighter">"Analyze your academic performance with retake support."</p>
            </div>

            <div class="grid grid-cols-12 gap-10">
                
                <!-- LEFT: INPUT SECTION (7 Columns) -->
                <div class="col-span-12 lg:col-span-7 space-y-10">
                    
                    <!-- CURRENT STANDING CARD -->
                    <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] p-10">
                        <h3 class="text-xs font-black text-blue-500 uppercase tracking-[0.4em] mb-8">Previous Statistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-xs font-black text-slate-400 mb-3 uppercase tracking-widest">Completed Credits</label>
                                <input type="number" id="prev-credits" placeholder="e.g. 60" oninput="calculate()" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-black text-[#003366] text-lg focus:ring-4 focus:ring-blue-50">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 mb-3 uppercase tracking-widest">Current CGPA</label>
                                <input type="number" id="prev-cgpa" step="0.01" placeholder="e.g. 3.50" oninput="calculate()" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-black text-[#003366] text-lg focus:ring-4 focus:ring-blue-50">
                            </div>
                        </div>
                    </div>

                    <!-- NEW COURSES CARD -->
                    <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] p-10">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xs font-black text-[#003366] uppercase tracking-[0.4em]">Current Trimester Courses</h3>
                            <button onclick="addRow('new')" class="bg-[#003366] text-white px-6 py-3 rounded-2xl text-[10px] font-black hover:bg-blue-800 transition-all shadow-lg shadow-blue-900/20">+ ADD COURSE</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="border-b border-slate-50">
                                    <tr class="text-[10px] text-slate-400 font-black uppercase tracking-widest">
                                        <th class="pb-6 px-2">Type</th>
                                        <th class="pb-6 px-2">Credits</th>
                                        <th class="pb-6 px-2 text-center">Grade</th>
                                        <th class="pb-6 px-2 text-right pr-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="new-course-list">
                                    <!-- JS will inject rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- RETAKE COURSES CARD -->
                    <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] p-10">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xs font-black text-orange-500 uppercase tracking-[0.4em]">Retake History Upgrade</h3>
                            <button onclick="addRow('retake')" class="bg-orange-500 text-white px-6 py-3 rounded-2xl text-[10px] font-black hover:bg-orange-600 transition-all shadow-lg shadow-orange-900/20">+ ADD RETAKE</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="border-b border-slate-50">
                                    <tr class="text-[10px] text-slate-400 font-black uppercase tracking-widest">
                                        <th class="pb-6 px-2">Credits</th>
                                        <th class="pb-6 px-2 text-center">Old Grade</th>
                                        <th class="pb-6 px-2 text-center">New Grade</th>
                                        <th class="pb-6 px-2 text-right pr-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="retake-course-list">
                                    <!-- JS will inject rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: RESULT SUMMARY (5 Columns) -->
                <div class="col-span-12 lg:col-span-5">
                    <div class="bg-[#001529] rounded-[4rem] p-12 sticky top-28 shadow-2xl overflow-hidden group">
                        <div class="relative z-10 space-y-12">
                            <div class="text-center">
                                <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.5em] mb-6">Trimester GPA</p>
                                <h2 id="res-tgpa" class="text-white text-7xl font-black tabular-nums tracking-tighter">0.00</h2>
                            </div>
                            
                            <div class="h-px bg-white/10 w-2/3 mx-auto"></div>

                            <div class="text-center">
                                <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.5em] mb-6">Estimated Final CGPA</p>
                                <h2 id="res-cgpa" class="text-white text-7xl font-black tabular-nums tracking-tighter">0.00</h2>
                            </div>

                            <div class="text-center pt-6">
                                <p id="imp-label" class="text-slate-500 text-[10px] font-black uppercase tracking-[0.5em] mb-3">Improvement Status</p>
                                <h4 id="res-imp" class="text-3xl font-black tracking-tight tabular-nums transition-all duration-500">0.000</h4>
                            </div>
                        </div>
                        
                        <!-- Background Glow Decoration -->
                        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-1000"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- CALCULATION SCRIPT -->
    <script>
        // 1. Grade Points Map based on UIU Policy
        const gradePoints = { "A": 4.00, "A-": 3.67, "B+": 3.33, "B": 3.00, "B-": 2.67, "C+": 2.33, "C": 2.00, "C-": 1.67, "D+": 1.33, "D": 1.00, "F": 0.00 };
        const gradeOptions = Object.entries(gradePoints).map(([g,p]) => `<option value="${p}">${g}</option>`).join('');

        /**
         * Dynamically add new rows to course tables
         */
        function addRow(type) {
            const container = document.getElementById(type === 'new' ? 'new-course-list' : 'retake-course-list');
            const row = document.createElement('tr');
            row.className = "border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors";
            
            if(type === 'new') {
                row.innerHTML = `
                    <td class="py-6 px-2">
                        <select class="bg-white border border-slate-200 rounded-xl p-3 font-bold text-sm focus:ring-4 focus:ring-blue-50" onchange="this.closest('tr').querySelector('.c-credits').value = this.value; calculate();">
                            <option value="3">Theory (3.0)</option>
                            <option value="1">Lab (1.0)</option>
                        </select>
                    </td>
                    <td class="py-6 px-2"><input type="number" class="c-credits w-24 bg-white border border-slate-200 rounded-xl p-3 font-black text-sm" value="3" step="0.5" oninput="calculate()"></td>
                    <td class="py-6 px-2 text-center"><select class="c-grade bg-white border border-slate-200 rounded-xl p-3 font-black text-sm" onchange="calculate()">${gradeOptions}</select></td>
                    <td class="py-6 px-2 text-right pr-4"><button onclick="this.closest('tr').remove(); calculate();" class="material-symbols-outlined text-slate-300 hover:text-red-500 text-2xl transition-colors">delete</button></td>
                `;
            } else {
                row.innerHTML = `
                    <td class="py-6 px-2"><input type="number" class="c-credits w-24 bg-white border border-slate-200 rounded-xl p-3 font-black text-sm" placeholder="Cr" step="0.5" oninput="calculate()"></td>
                    <td class="py-6 px-2 text-center"><select class="c-old-grade bg-white border border-slate-200 rounded-xl p-3 font-black text-sm" onchange="calculate()">${gradeOptions}</select></td>
                    <td class="py-6 px-2 text-center"><select class="c-new-grade bg-white border border-slate-200 rounded-xl p-3 font-black text-sm" onchange="calculate()">${gradeOptions}</select></td>
                    <td class="py-6 px-2 text-right pr-4"><button onclick="this.closest('tr').remove(); calculate();" class="material-symbols-outlined text-slate-300 hover:text-red-500 text-2xl transition-colors">delete</button></td>
                `;
            }
            container.appendChild(row);
            calculate();
        }

        /**
         * Core Calculation Logic
         */
        function calculate() {
            // Get initial values from inputs
            const prevCredits = parseFloat(document.getElementById('prev-credits').value) || 0;
            const prevCGPA = parseFloat(document.getElementById('prev-cgpa').value) || 0;
            
            let trimesterPoints = 0;
            let trimesterCredits = 0;
            let netPointsDifference = 0;
            let totalNewCredits = 0;

            // 2. Process New Trimester Courses
            document.querySelectorAll('#new-course-list tr').forEach(row => {
                const cr = parseFloat(row.querySelector('.c-credits').value) || 0;
                const gr = parseFloat(row.querySelector('.c-grade').value) || 0;
                trimesterPoints += (cr * gr);
                trimesterCredits += cr;
                totalNewCredits += cr;
            });

            // 3. Process Retakes (Retake Logic: Update points, don't add credits)
            document.querySelectorAll('#retake-course-list tr').forEach(row => {
                const cr = parseFloat(row.querySelector('.c-credits').value) || 0;
                const oldG = parseFloat(row.querySelector('.c-old-grade').value) || 0;
                const newG = parseFloat(row.querySelector('.c-new-grade').value) || 0;
                
                trimesterPoints += (cr * newG);
                trimesterCredits += cr;

                // Points Adjustment: Add the point difference to the historical total
                netPointsDifference += (cr * (newG - oldG));
            });

            // 4. Calculate Final Stats
            const tgpa = trimesterCredits > 0 ? (trimesterPoints / trimesterCredits) : 0;
            
            // Total Credits only increases by New Courses, not Retakes
            const finalTotalCredits = prevCredits + totalNewCredits;
            
            // Formula: ((Old Credits * Old CGPA) + (New Course Points) + (Retake Points Difference)) / Final Credits
            const finalCGPA = finalTotalCredits > 0 
                ? ((prevCredits * prevCGPA) + (trimesterPoints - Array.from(document.querySelectorAll('#retake-course-list tr')).reduce((acc, r) => acc + (parseFloat(r.querySelector('.c-credits').value || 0) * parseFloat(r.querySelector('.c-new-grade').value || 0)), 0)) + netPointsDifference) / finalTotalCredits 
                : 0;

            // 5. Update UI Elements
            document.getElementById('res-tgpa').innerText = tgpa.toFixed(2);
            document.getElementById('res-cgpa').innerText = finalCGPA.toFixed(2);
            
            const improvement = finalCGPA - prevCGPA;
            const impDisplay = document.getElementById('res-imp');
            impDisplay.innerText = (improvement >= 0 ? "+" : "") + improvement.toFixed(3);
            impDisplay.className = 'text-3xl font-black tracking-tight tabular-nums ' + (improvement >= 0 ? 'text-green-400' : 'text-red-500');
        }

        // Initialize with one empty course row
        addRow('new');
    </script>
</x-layout>