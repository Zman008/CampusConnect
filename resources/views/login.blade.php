<x-layout>
    <main class="flex-grow flex items-center justify-center px-6 pt-50 pb-20">
        <div class="max-w-md w-full bg-white rounded-3xl p-10 shadow-2xl border border-gray-200">
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-extrabold text-[#003366] mb-2 tracking-tight">Welcome back</h2>
                <p class="text-gray-600 font-medium">Enter your academic credentials to continue.</p>
            </div>
            <form class="space-y-6" method="POST" action=" {{ route('login.authenticate') }}">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-[#003366] mb-2 ml-1" for="email">Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-700 transition-colors" data-icon="person">person</span>
                        <input class="w-full pl-12 pr-4 py-4 bg-slate-50 rounded-xl border border-gray-200 transition-all text-gray-900 font-medium placeholder:text-slate-400 @error('email') border-red-500 @enderror [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" id="email" name="email" placeholder="Enter your email" type="email" value="{{ old('email') }}" required />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2 px-1">
                        <label class="text-sm font-bold text-[#003366]" for="password">Password</label>
                        <a class="text-sm font-bold text-orange-600 hover:text-orange-700 transition-colors" href="">Forgot Password?</a>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-700 transition-colors" data-icon="lock">lock</span>
                        <input class="w-full pl-12 pr-4 py-4 bg-slate-50 rounded-xl border border-gray-200 transition-all text-gray-900 font-medium placeholder:text-slate-400 @error('password') border-red-500 @enderror" id="password" name="password" placeholder="••••••••" type="password" required />
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 px-1">
                    <input class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-all" id="remember" name="remember" type="checkbox" />
                    <label class="text-sm font-semibold text-on-surface-variant cursor-pointer" for="remember">Keep me signed in for 30 days</label>
                </div>
                <button class="w-full bg-gradient-to-r from-[#003366] to-blue-800 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-blue-500/20 hover:shadow-blue-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-3 group" type="submit">
                    Sign In
                    <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform" data-icon="arrow_forward">arrow_forward</span>
                </button>
            </form>
            <div class="mt-10 pt-8 border-t border-surface-container text-center">
                <p class="text-on-surface-variant font-medium">
                    New to Campus Connect?
                    <a class="text-academic-orange font-bold hover:text-academic-orange/80 transition-colors ml-1" href="/register">Create Account</a>
                </p>
            </div>
            
        </div>
    </main>
</x-layout>
