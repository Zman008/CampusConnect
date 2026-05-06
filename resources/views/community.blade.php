<x-layout>
    <x-slot:title>Community | CampusConnect</x-slot:title>

    <main class="pt-28 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1600px] mx-auto px-6 md:px-12">
            <div class="text-center lg:text-left mb-16">
                <h1 class="text-5xl lg:text-6xl font-black text-[#003366] tracking-tight mb-3">Community Groups</h1>
                <p class="text-slate-500 font-bold italic text-xl lg:text-2xl">
                    Connect with fellow students in university-related groups.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($groups as $group)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow cursor-pointer" onclick="window.location.href='{{ route('community.group', $group->id) }}'">
                        <h3 class="text-2xl font-bold text-[#003366] mb-2">{{ $group->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $group->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">{{ $group->messages()->count() }} messages</span>
                            <a href="{{ route('community.group', $group->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Join Chat
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No groups available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
