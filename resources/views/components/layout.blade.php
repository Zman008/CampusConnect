<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Manrope:wght@700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <title>{{ $title ?? 'CampusConnect' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 selection:bg-orange-300">
    <!-- TopNavBar -->
    <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200">
        <div class="flex justify-between items-center w-full px-8 py-4 max-w-[80%] mx-auto">
            <div class="flex items-center gap-12 text-[#003366]">
                <span class="text-2xl font-extrabold tracking-tighter flex items-center gap-2"
                    onclick="window.location.href='/dashboard'" style="cursor: pointer;"> <!-- পরিবর্তন ১: লোগোতে ক্লিক করলে এখন সরাসরি ড্যাশবোর্ডে যাবে -->
                    <span class="w-10 h-10 bg-[#003366] rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white font-thin text-xs text-[10px]">school</span>
                    </span>
                    Campus Connect
                </span>
                <div class="hidden md:flex items-center gap-8">
                    <!-- পরিবর্তন ২: নিচের লাইনে href="/" বদলে href="/dashboard" করা হয়েছে -->
                    <!-- কারণ: "/" হলো হোমপেজ (খালি), আর "/dashboard" হলো আপনার আসল কাজের জায়গা -->
                    <a class="{{ request()->is('dashboard') ? 'font-bold border-b-2 border-blue-500' : 'text-slate-500' }} pb-1 transition-all" href="/dashboard">Dashboard</a>

                    <div class="relative group py-2">
                        <button
                            class="text-slate-500 font-medium hover:text-blue-700 transition-colors border-b-2 border-transparent group-hover:border-blue-500 pb-1 flex items-center gap-1 cursor-pointer">
                            Academic Hub
                        </button>

                        <div
                            class="absolute left-1/2 -translate-x-1/2 left-0 top-full pt-2 max-w-prose opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div
                                class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden flex flex-col py-1">
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">Question Bank</a>
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">Course Material</a>
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">Class Links</a>
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">Academic Calendar</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group py-2">
                        <button
                            class="text-slate-500 font-medium hover:text-blue-700 transition-colors border-b-2 border-transparent group-hover:border-blue-500 pb-1 flex items-center gap-1 cursor-pointer">
                            Planners
                        </button>

                        <div
                            class="absolute left-1/2 -translate-x-1/2 left-0 top-full pt-2 max-w-prose opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div
                                class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden flex flex-col py-1">
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">Course
                                    Planner</a>
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">Section
                                    Planner</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group py-2">
                        <button
                            class="text-slate-500 font-medium hover:text-blue-700 transition-colors border-b-2 border-transparent group-hover:border-blue-500 pb-1 flex items-center gap-1 cursor-pointer">
                            Calculator
                        </button>

                        <div
                            class="absolute left-1/2 -translate-x-1/2 left-0 top-full pt-2 max-w-prose opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div
                                class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden flex flex-col py-1">
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">Tuition
                                    Fee Calculator</a>
                                <a href="#"
                                    class="px-4 py-2.5 text-sm text-gray-600 hover:bg-blue-50 hover:text-academic-blue transition-colors whitespace-nowrap">CGPA
                                    Calculator</a>
                            </div>
                        </div>
                    </div>

                    <a class="text-slate-500 font-medium hover:text-blue-700 transition-colors hover:border-b-2 hover:border-blue-500 pb-1"
                        href="#">Community</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm font-medium text-gray-600">Hello, {{ Auth::user()->username }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="px-6 py-2 rounded-full bg-gradient-to-r from-[#003366] to-blue-800 text-white font-semibold text-sm hover:shadow-lg hover:shadow-blue-500/20 hover:cursor-pointer transition-all"
                            type="submit">
                            Log Out
                        </button>
                    </form>

                @endauth
                
                @guest
                    <button
                        class="px-6 py-2 rounded-full bg-gradient-to-r from-[#003366] to-blue-800 text-white font-semibold text-sm hover:shadow-lg hover:shadow-blue-500/20 hover:cursor-pointer transition-all"
                        onclick="window.location.href='/login'">
                        Log In
                    </button>
                    <button
                        class="px-6 py-2 rounded-full bg-gradient-to-r from-[#003366] to-blue-800 text-white font-semibold text-sm hover:shadow-lg hover:shadow-blue-500/20 hover:cursor-pointer transition-all"
                        onclick="window.location.href='/register'">
                        Sign Up
                    </button>
                @endguest
            </div>
        </div>
    </nav>

    {{ $slot }}

</body>

</html>