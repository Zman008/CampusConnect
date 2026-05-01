<x-layout>
    <x-slot:title>Tuition Fee Calculator | CampusConnect</x-slot:title>

    <main class="pt-28 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1500px] mx-auto px-6 md:px-12">
            
            <!-- HEADER SECTION -->
            <div class="mb-16 text-center lg:text-left">
                <h1 class="text-6xl font-[900] text-[#003366] tracking-tight mb-3 uppercase">Tuition Fee Calculator</h1>
                <p class="text-slate-600 font-black italic text-2xl uppercase tracking-tighter text-blue-600">
                    "CSE Department Logic: Trimester-wise Expense Planner"
                </p>
            </div>

            <div class="grid grid-cols-12 gap-10">
                
                <!-- LEFT: INPUT SECTION (7 Columns) -->
                <div class="col-span-12 lg:col-span-7 space-y-10">
                    
                    <!-- STEP 1: BATCH SELECTION (BATCH WISE PRICING) -->
                    <div class="bg-white rounded-[3.5rem] border-2 border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] p-12">
                        <h3 class="text-lg font-[900] text-blue-800 uppercase tracking-[0.4em] mb-10 border-b-2 pb-4">Step 1: Select Fee Structure</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Old Batch Option -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="fee_type" value="5000" checked onchange="updateBatch(5000)" class="peer hidden">
                                <div class="p-8 bg-slate-50 border-4 border-transparent rounded-[2.5rem] peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Old Batch Rate</p>
                                    <h4 class="text-4xl font-[900] text-slate-800">5,000 <span class="text-base font-bold">/ credit</span></h4>
                                    <p class="text-xs font-bold text-blue-500 mt-2">Trimester Fee: 5,000 BDT</p>
                                </div>
                            </label>

                            <!-- New Batch Option -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="fee_type" value="6500" onchange="updateBatch(6500)" class="peer hidden">
                                <div class="p-8 bg-slate-50 border-4 border-transparent rounded-[2.5rem] peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-2">New Batch Rate</p>
                                    <h4 class="text-4xl font-[900] text-slate-800">6,500 <span class="text-base font-bold">/ credit</span></h4>
                                    <p class="text-xs font-bold text-blue-500 mt-2">Trimester Fee: 6,500 BDT</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- STEP 2: CREDITS AND SCHOLARSHIP -->
                    <div class="bg-white rounded-[3.5rem] border-2 border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] p-12">
                        <h3 class="text-lg font-[900] text-blue-800 uppercase tracking-[0.4em] mb-10 border-b-2 pb-4">Step 2: Course & Waiver Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- Fresh Credits -->
                            <div>
                                <label class="block text-base font-[900] text-slate-900 mb-4 uppercase tracking-widest">Fresh Credits</label>
                                <input type="number" id="fresh-credits" placeholder="e.g. 9" oninput="calculateTuition()" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl p-6 font-[900] text-[#003366] text-2xl focus:ring-4 focus:ring-blue-100 transition-all">
                            </div>
                            
                            <!-- Retake Credits (50% Off Logic) -->
                            <div>
                                <label class="block text-base font-[900] text-slate-900 mb-4 uppercase tracking-widest text-orange-600">Retake Credits (50% Off)</label>
                                <input type="number" id="retake-credits" placeholder="e.g. 3" oninput="calculateTuition()" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl p-6 font-[900] text-[#003366] text-2xl focus:ring-4 focus:ring-blue-100 transition-all">
                            </div>

                            <!-- Scholarship Selection -->
                            <div class="md:col-span-2">
                                <label class="block text-base font-[900] text-slate-900 mb-4 uppercase tracking-widest">Scholarship / Waiver Percentage</label>
                                <select id="scholarship-pct" onchange="calculateTuition()" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl p-6 font-[900] text-[#003366] text-2xl focus:ring-4 focus:ring-blue-100 transition-all">
                                    <option value="0">No Scholarship (0%)</option>
                                    <option value="25">25% Waiver</option>
                                    <option value="50">50% Waiver</option>
                                    <option value="100">100% Waiver (Must pay Trimester Fee)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: INSTALLMENT BREAKDOWN -->
                    <div class="bg-white rounded-[3.5rem] border-2 border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] p-12">
                        <h3 class="text-lg font-[900] text-orange-600 uppercase tracking-[0.4em] mb-10 border-b-2 pb-4 text-center">Installment Breakdown</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- 1st Installment -->
                            <div class="text-center p-8 bg-slate-50 rounded-[2.5rem] border-2 border-slate-100">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">1st (40%)</p>
                                <h4 id="inst-1" class="text-2xl font-[900] text-[#003366] tabular-nums">0</h4>
                                <p class="text-[10px] font-black text-slate-300 mt-2">At Registration</p>
                            </div>
                            <!-- 2nd Installment -->
                            <div class="text-center p-8 bg-slate-50 rounded-[2.5rem] border-2 border-slate-100">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">2nd (30%)</p>
                                <h4 id="inst-2" class="text-2xl font-[900] text-[#003366] tabular-nums">0</h4>
                                <p class="text-[10px] font-black text-slate-300 mt-2">Before Midterm</p>
                            </div>
                            <!-- 3rd Installment -->
                            <div class="text-center p-8 bg-slate-50 rounded-[2.5rem] border-2 border-slate-100">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">3rd (30%)</p>
                                <h4 id="inst-3" class="text-2xl font-[900] text-[#003366] tabular-nums">0</h4>
                                <p class="text-[10px] font-black text-slate-300 mt-2">Before Final</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: RESULTS SUMMARY (5 Columns) -->
                <div class="col-span-12 lg:col-span-5">
                    <div class="bg-[#001529] rounded-[4rem] p-16 sticky top-28 shadow-2xl overflow-hidden group border-[6px] border-blue-900/30">
                        <div class="relative z-10 space-y-14">
                            <!-- Trimester Fee Display -->
                            <div class="text-center">
                                <p class="text-blue-400 text-sm font-[900] uppercase tracking-[0.6em] mb-6">Trimester Fee (Fixed)</p>
                                <h2 id="display-sem-fee" class="text-white text-8xl font-[900] tabular-nums tracking-tighter">5,000</h2>
                            </div>
                            
                            <div class="h-1.5 bg-white/10 w-full rounded-full"></div>

                            <!-- Total Credit Fee Display -->
                            <div class="text-center">
                                <p class="text-blue-400 text-sm font-[900] uppercase tracking-[0.6em] mb-6">Tuition (After Waiver)</p>
                                <h2 id="display-tuition" class="text-white text-8xl font-[900] tabular-nums tracking-tighter">0</h2>
                            </div>

                            <!-- Net Total Display -->
                            <div class="bg-blue-600 p-12 rounded-[3.5rem] text-center shadow-2xl border-2 border-blue-400/30">
                                <p class="text-blue-100 text-sm font-[900] uppercase tracking-[0.6em] mb-4">Net Payable Amount</p>
                                <h2 id="res-total" class="text-white text-[6rem] leading-none font-[900] tabular-nums tracking-tighter">5,000</h2>
                                <p class="text-white/40 text-xs font-[900] mt-6 uppercase tracking-[0.2em]">BDT // CSE DEPT LOGIC</p>
                            </div>
                        </div>
                        
                        <!-- Decorative Glow -->
                        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px]"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- CALCULATION LOGIC -->
    <script>
        // Global variables to track current rates
        let currentRate = 5000;
        let semesterFee = 5000;

        /**
         * Update batch-specific fees (Old: 5000, New: 6500)
         */
        function updateBatch(rate) {
            currentRate = rate;
            semesterFee = rate; // In UIU CSE, trimester fee matches credit rate for these batches
            document.getElementById('display-sem-fee').innerText = semesterFee.toLocaleString();
            calculateTuition();
        }

        /**
         * Main Tuition Calculation Function
         */
        function calculateTuition() {
            // Get inputs
            const freshCredits = parseFloat(document.getElementById('fresh-credits').value) || 0;
            const retakeCredits = parseFloat(document.getElementById('retake-credits').value) || 0;
            const scholarshipPct = parseFloat(document.getElementById('scholarship-pct').value) || 0;

            // 1. Calculate Gross Tuition for Credits
            const freshFee = freshCredits * currentRate;
            
            // 2. Retake Logic: 50% discount on credit fee
            const retakeFee = (retakeCredits * currentRate) * 0.5;

            const totalTuitionCreditsOnly = freshFee + retakeFee;

            // 3. Apply Scholarship only to Credit Tuition (Semester fee is mandatory)
            const waiverAmount = (totalTuitionCreditsOnly * scholarshipPct) / 100;
            const netTuition = totalTuitionCreditsOnly - waiverAmount;

            // 4. Final Total = Net Tuition + Fixed Semester Fee
            const totalPayable = netTuition + semesterFee;

            // Update Result Display
            document.getElementById('display-tuition').innerText = netTuition.toLocaleString();
            document.getElementById('res-total').innerText = totalPayable.toLocaleString();

            // 5. Installment Logic (40% - 30% - 30%)
            document.getElementById('inst-1').innerText = Math.round(totalPayable * 0.4).toLocaleString();
            document.getElementById('inst-2').innerText = Math.round(totalPayable * 0.3).toLocaleString();
            document.getElementById('inst-3').innerText = Math.round(totalPayable * 0.3).toLocaleString();
        }

        // Run calculation once on load to show base semester fee
        calculateTuition();
    </script>
</x-layout>