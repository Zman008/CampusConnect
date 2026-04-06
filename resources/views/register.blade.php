<x-layout>
    <main class="flex-grow flex items-center justify-center p-6 md:p-12 lg:pt-32 lg:pb-24 relative overflow-hidden">
        <div class="absolute -top-1/5 -left-1/10 w-3/5 h-3/5 bg-blue-100/40 rounded-full blur-[150px] -z-10"></div>
        <div class="absolute -bottom-1/10 -right-1/20 w-2/5 h-2/5 bg-indigo-100/30 rounded-full blur-[120px] -z-10"></div>
        <div class="w-full max-w-2xl">
            <!-- Registration Form Card -->
            <div class="bg-white rounded-3xl p-8 md:p-14 shadow-[0_20px_50px_rgba(0,51,102,0.08)] border border-gray-200/30">
                <header class="mb-12 text-center">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Create Student Account</h2>
                    <p class="text-gray-600 font-medium">Already part of the community? <a class="text-blue-700 font-bold hover:underline transition-all" href="/login">Sign In</a></p>
                </header>
                <form class="space-y-8" method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-500/70" for="full_name">Username</label>
                            <input class="w-full bg-slate-50 border border-gray-200 rounded-xl px-5 py-4 transition-all placeholder:text-gray-400" id="username" name="username" placeholder="Enter your username" type="text" value="{{ old('username') }}" required />
                            @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <!-- Student ID -->
                        <div class="space-y-2">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-500/70" for="student_id">Student ID</label>
                            <input class="w-full bg-slate-50 border border-gray-200 rounded-xl px-5 py-4 transition-all placeholder:text-gray-400" id="student_id" name="student_id" placeholder="Enter your student ID" type="text" value="{{ old('student_id') }}" required />
                            @error('student_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <!-- University Email -->
                    <div class="space-y-2">
                        <label class="block text-xs uppercase tracking-widest font-bold text-gray-500/70" for="email">University Email</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-700 transition-colors">mail</span>
                            <input class="w-full bg-slate-50 border border-gray-200 rounded-xl pl-14 pr-5 py-4 transition-all placeholder:text-gray-400" id="email" name="email" placeholder="Enter your university email" type="email" value="{{ old('email') }}" required />
                        </div>
                        @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <!-- Academic Department -->
                    <div class="space-y-2">
                        <label class="block text-xs uppercase tracking-widest font-bold text-gray-500/70" for="University">University</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-700 transition-colors">school</span>
                            <input class="w-full bg-slate-50 border border-gray-200 rounded-xl pl-14 pr-5 py-4 transition-all placeholder:text-gray-400" id="university" name="university" placeholder="Enter the name of your university" type="text" value="{{ old('university') }}" required />
                        </div>
                        @error('university') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-500/70" for="password">Password</label>
                            <input class="w-full bg-slate-50 border border-gray-200 rounded-xl px-5 py-4 transition-all placeholder:text-gray-400" id="password" name="password" placeholder="••••••••" type="password" required />
                            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-500/70" for="confirm_password">Confirm Password</label>
                            <input class="w-full bg-slate-50 border border-gray-200 rounded-xl px-5 py-4 transition-all placeholder:text-gray-400" id="confirm_password" name="password_confirmation" placeholder="••••••••" type="password" required />
                        </div>
                    </div>
                    <!-- Terms of Service -->
                    <div class="flex items-start gap-4 py-2">
                        <div class="pt-1">
                            <input class="w-5 h-5 rounded border-gray-300 text-blue-600 transition-all" id="terms" name="terms" type="checkbox" required />
                        </div>
                        <label class="text-sm text-gray-600 leading-relaxed font-medium" for="terms">
                            I agree to the <a class="text-blue-700 hover:underline font-bold" href="#">Terms of Service</a> and <a class="text-blue-700 hover:underline font-bold" href="#">Privacy Policy</a> regarding my student data.
                        </label>
                    </div>
                    <!-- Submit Button -->
                    <button class="w-full bg-gradient-to-r from-blue-800 to-indigo-600 text-white py-5 px-8 rounded-xl font-bold text-lg hover:shadow-2xl hover:shadow-blue-500/30 active:scale-[0.99] transition-all flex items-center justify-center gap-3" type="submit">
                        Create My Account
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
                    </button>
                </form>
                <div class="mt-12 pt-10 border-t border-gray-200/50 text-center">
                    <p class="text-sm text-gray-600 font-medium mb-4">Need technical assistance?</p>
                    <a class="text-blue-700 font-extrabold text-xs uppercase tracking-[0.2em] hover:text-indigo-700 transition-colors inline-flex items-center gap-2" href="#">
                        <span class="material-symbols-outlined text-sm" aria-hidden="true">support_agent</span>
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-layout>
