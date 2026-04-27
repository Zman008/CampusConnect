<x-layout>
    <x-slot:title>Welcome | CampusConnect</x-slot:title>

    <main class="min-h-screen bg-white selection:bg-blue-100 selection:text-blue-900">
        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10 text-center lg:text-left">
                <div class="grid lg:grid-cols-2 items-center gap-16">
                    <div>
                        <span class="inline-block px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-black uppercase tracking-widest mb-6">
                            Unified Student Ecosystem
                        </span>
                        <h1 class="text-5xl lg:text-7xl font-black text-[#003366] leading-[1.1] mb-8 tracking-tighter">
                            Organize your <br> <span class="text-blue-600">University Life</span> in one place.
                        </h1>
                        <p class="text-lg lg:text-xl text-slate-500 font-medium mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0">
                            CampusConnect helps you manage tasks, track exams, calculate CGPA, and access university resources—all from a single, beautiful dashboard.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="/register" class="px-10 py-5 bg-[#003366] text-white rounded-2xl font-black text-lg hover:bg-blue-800 transition-all shadow-xl shadow-blue-900/20">
                                Get Started Free
                            </a>
                            <a href="/login" class="px-10 py-5 bg-white text-slate-700 border-2 border-slate-100 rounded-2xl font-black text-lg hover:bg-slate-50 transition-all">
                                Log In to Workspace
                            </a>
                        </div>
                    </div>

                    <!-- Hero Visual / Bento Preview -->
                    <div class="relative hidden lg:block">
                        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl"></div>
                        <div class="bg-slate-50 p-8 rounded-[3rem] border border-slate-100 rotate-2 shadow-2xl relative">
                            <div class="space-y-4">
                                <div class="h-8 w-32 bg-slate-200 rounded-full animate-pulse"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="h-32 bg-white rounded-3xl border border-slate-100 shadow-sm"></div>
                                    <div class="h-32 bg-blue-600 rounded-3xl shadow-lg"></div>
                                </div>
                                <div class="h-24 bg-white rounded-3xl border border-slate-100 shadow-sm"></div>
                            </div>
                            <!-- Small Floating Indicators -->
                            <div class="absolute -top-4 -right-4 w-12 h-12 bg-orange-400 rounded-2xl shadow-lg flex items-center justify-center text-white font-black animate-bounce">
                                <span class="material-symbols-outlined">star</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid -->
        <section class="py-24 bg-slate-50/50">
            <div class="max-w-[1400px] mx-auto px-6 md:px-12 text-center">
                <h2 class="text-3xl lg:text-5xl font-black text-[#003366] mb-4 tracking-tighter">Everything you need to excel.</h2>
                <p class="text-slate-400 font-bold mb-16 uppercase tracking-[0.3em] text-sm">Built by Pipeline Mechanics</p>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl font-bold">dashboard_customize</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-800 mb-3">Bento Dashboard</h4>
                        <p class="text-slate-500 font-medium text-sm leading-relaxed">A perfectly balanced workspace to visualize your day and deadlines.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                        <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl font-bold">school</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-800 mb-3">Academic Hub</h4>
                        <p class="text-slate-500 font-medium text-sm leading-relaxed">Centralized bank for slides, course materials, and previous year questions.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                        <div class="w-16 h-16 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl font-bold">calculate</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-800 mb-3">CGPA Planner</h4>
                        <p class="text-slate-500 font-medium text-sm leading-relaxed">Track your academic progress and simulate your GPA with ease.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                        <div class="w-16 h-16 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl font-bold">groups</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-800 mb-3">Community</h4>
                        <p class="text-slate-500 font-medium text-sm leading-relaxed">Connect with peers, share knowledge, and build a unified ecosystem.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 text-center">
            <div class="max-w-[1400px] mx-auto px-6 md:px-12 border-t border-slate-100 pt-12">
                <p class="text-slate-300 text-xs font-black uppercase tracking-[0.5em]">
                    Pipeline Mechanics // UIU CampusConnect
                </p>
            </div>
        </footer>
    </main>
</x-layout>