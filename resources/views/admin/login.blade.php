<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | CampusConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <main class="min-h-screen py-16 bg-slate-100 flex items-start justify-center px-6">
        <section class="w-full max-w-md bg-white border border-slate-200 rounded-lg shadow-xl p-8">
            <div class="mb-8">
                <p class="text-sm font-bold uppercase text-blue-700">Admin Panel</p>
                <h1 class="text-3xl font-black text-[#003366] mt-1">Sign in</h1>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm font-semibold text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-bold text-slate-700 mb-2">Username</label>
                    <input id="username" name="username" value="{{ old('username') }}" required autocomplete="username" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('username') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full rounded-lg bg-[#003366] px-5 py-3 font-bold text-white hover:bg-blue-900 transition-colors">
                    Open Admin Panel
                </button>
            </form>
        </section>
    </main>
</body>
</html>
