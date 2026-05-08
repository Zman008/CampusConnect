<x-layout>
    <x-slot:title>Academic Calendar | CampusConnect</x-slot:title>

    @php
        $today = now()->startOfDay();

        $events = [
            ['date' => 'Feb 23 - 25, 2026', 'start' => '2026-02-23', 'end' => '2026-02-25', 'day' => 'Mon - Wed', 'title' => 'Course Advising & Registration', 'type' => 'important'],
            ['date' => 'Feb 25, 2026', 'start' => '2026-02-25', 'day' => 'Wed', 'title' => 'Last day of Course Advising & Registration without Fine', 'type' => 'deadline'],
            ['date' => 'Feb 28, 2026', 'start' => '2026-02-28', 'day' => 'Sat', 'title' => 'Classes Begin', 'type' => 'important'],
            ['date' => 'Mar 2, 2026', 'start' => '2026-03-02', 'day' => 'Mon', 'title' => 'Last day to drop course(s) with 100% adjustable refund', 'type' => 'deadline'],
            ['date' => 'Mar 7, 2026', 'start' => '2026-03-07', 'day' => 'Sat', 'title' => 'Last day to apply for Grade Change of a course (if any) of Fall 2025 Trimester', 'type' => 'important'],
            ['date' => 'Mar 9, 2026', 'start' => '2026-03-09', 'day' => 'Mon', 'title' => 'Last day to drop course(s) with 50% adjustable refund', 'type' => 'deadline'],
            ['date' => 'Mar 10, 2026', 'start' => '2026-03-10', 'day' => 'Tue', 'title' => 'Last day of Grade Submission for Project/Thesis (Final Year Design Project/Internship)', 'type' => 'important'],
            ['date' => 'Mar 15, 2026', 'start' => '2026-03-15', 'day' => 'Sun', 'title' => 'Last day of Course Advising & Registration with a Fine of Tk. 500/-', 'type' => 'deadline'],
            ['date' => 'Mar 17 - 27, 2026', 'start' => '2026-03-17', 'end' => '2026-03-27', 'day' => 'Tue - Fri', 'title' => "Holiday: Jumu'atul-Widaa/Shab-e-Qad'r/Eid-ul-Fitr/Independence Day", 'type' => 'holiday'],
            ['date' => 'Mar 31, 2026', 'start' => '2026-03-31', 'day' => 'Tue', 'title' => 'Last day of Grade Submission of Incomplete Grades of Fall 2025 Trimester', 'type' => 'important'],
            ['date' => 'Apr 12, 2026', 'start' => '2026-04-12', 'day' => 'Sun', 'title' => 'Last date of 1st installment*', 'type' => 'important'],
            ['date' => 'Apr 13, 2026', 'start' => '2026-04-13', 'day' => 'Mon', 'title' => 'Make-up class: Regular Tuesday Classes', 'type' => 'important'],
            ['date' => 'Apr 14, 2026', 'start' => '2026-04-14', 'day' => 'Tue', 'title' => 'Holiday: Bangla New Year', 'type' => 'holiday'],
            ['date' => 'Apr 18 - 24, 2026', 'start' => '2026-04-18', 'end' => '2026-04-24', 'day' => 'Sat - Fri', 'title' => 'Mid-Term Exam', 'type' => 'exam'],
            ['date' => 'Apr 25, 2026', 'start' => '2026-04-25', 'day' => 'Sat', 'title' => 'Regular Tuesday Classes', 'type' => 'important'],
            ['date' => 'Apr 26, 2026', 'start' => '2026-04-26', 'day' => 'Sun', 'title' => 'Regular Wednesday Classes', 'type' => 'important'],
            ['date' => 'May 1, 2026', 'start' => '2026-05-01', 'day' => 'Fri', 'title' => 'Holiday: Buddha Purnima and May Day', 'type' => 'holiday'],
            ['date' => 'May 4, 2026', 'start' => '2026-05-04', 'day' => 'Mon', 'title' => 'Last Date for Course Withdrawal', 'type' => 'deadline'],
            ['date' => 'May 12, 2026', 'start' => '2026-05-12', 'day' => 'Tue', 'title' => 'Last date of 2nd Installment**', 'type' => 'deadline'],
            ['date' => 'May 26 - June 05, 2026', 'start' => '2026-05-26', 'end' => '2026-06-05', 'day' => 'Tue - Fri', 'title' => 'Holiday: Eid-ul-Adha', 'type' => 'holiday'],
            ['date' => 'June 14, 2026', 'start' => '2026-06-14', 'day' => 'Sun', 'title' => 'Last date of 3rd installment***', 'type' => 'important'],
            ['date' => 'June 18 - 20, 2026', 'start' => '2026-06-18', 'end' => '2026-06-20', 'day' => 'Thu - Sat', 'title' => 'Classes will remain suspended for Exam preparation', 'type' => 'notice'],
            ['date' => 'June 21 - 28, 2026', 'start' => '2026-06-21', 'end' => '2026-06-28', 'day' => 'Sun - Sun', 'title' => 'Final Exam', 'type' => 'exam'],
            ['date' => 'June 26, 2026', 'start' => '2026-06-26', 'day' => 'Fri', 'title' => 'Holiday: Ashura****', 'type' => 'holiday'],
            ['date' => 'July 2, 2026', 'start' => '2026-07-02', 'day' => 'Thu', 'title' => 'Last date of Grade Submission (including Self-Study courses)', 'type' => 'important'],
        ];

        $typeStyles = [
            'deadline' => ['label' => 'Deadline', 'icon' => 'priority_high', 'dot' => 'bg-rose-500', 'iconText' => 'text-rose-500', 'pill' => 'bg-rose-50 text-rose-700 ring-rose-200', 'row' => 'hover:bg-rose-50/70', 'accent' => 'border-rose-200 bg-rose-50 text-rose-700'],
            'important' => ['label' => 'Important', 'icon' => 'event_available', 'dot' => 'bg-blue-500', 'iconText' => 'text-blue-500', 'pill' => 'bg-blue-50 text-blue-700 ring-blue-200', 'row' => 'hover:bg-blue-50/70', 'accent' => 'border-blue-200 bg-blue-50 text-blue-700'],
            'exam' => ['label' => 'Exam', 'icon' => 'edit_note', 'dot' => 'bg-violet-500', 'iconText' => 'text-violet-500', 'pill' => 'bg-violet-50 text-violet-700 ring-violet-200', 'row' => 'hover:bg-violet-50/70', 'accent' => 'border-violet-200 bg-violet-50 text-violet-700'],
            'holiday' => ['label' => 'Holiday', 'icon' => 'beach_access', 'dot' => 'bg-amber-500', 'iconText' => 'text-amber-500', 'pill' => 'bg-amber-50 text-amber-700 ring-amber-200', 'row' => 'hover:bg-amber-50/70', 'accent' => 'border-amber-200 bg-amber-50 text-amber-700'],
            'notice' => ['label' => 'Notice', 'icon' => 'campaign', 'dot' => 'bg-teal-500', 'iconText' => 'text-teal-500', 'pill' => 'bg-teal-50 text-teal-700 ring-teal-200', 'row' => 'hover:bg-teal-50/70', 'accent' => 'border-teal-200 bg-teal-50 text-teal-700'],
        ];

        $events = collect($events)->map(function ($event) use ($today) {
            $start = \Carbon\Carbon::parse($event['start'])->startOfDay();
            $end = \Carbon\Carbon::parse($event['end'] ?? $event['start'])->startOfDay();

            $event['daysUntil'] = $today->diffInDays($start, false);
            $event['isToday'] = $today->betweenIncluded($start, $end);
            $event['isPast'] = $end->lt($today);
            $event['isUpcoming'] = $event['daysUntil'] > 0 && $event['daysUntil'] <= 7;

            return $event;
        });

        $nextEvent = $events->first(fn ($event) => !$event['isPast'] && !$event['isToday']);
        $activeEvent = $events->first(fn ($event) => $event['isToday']);
        $deadlineCount = $events->where('type', 'deadline')->count();
        $holidayCount = $events->where('type', 'holiday')->count();
    @endphp

    <main class="min-h-screen bg-[#f7f9fc] pt-28 pb-14 antialiased">
        <div class="mx-auto max-w-[1500px] px-5 md:px-10">
            <section class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <div class="mb-3 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#003366] px-3.5 py-1.5 text-xs font-black uppercase tracking-[0.16em] text-white">
                            <span class="material-symbols-outlined text-base">calendar_month</span>
                            Spring 2026
                        </span>
                        <span class="rounded-full border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-slate-500">
                            Feb 23 - Jul 2
                        </span>
                    </div>
                    <h1 class="text-3xl font-black tracking-tight text-[#003366] md:text-4xl">Academic Calendar</h1>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Today</p>
                    <p class="mt-1 font-['Manrope',Inter,sans-serif] text-xl font-extrabold text-slate-900 tabular-nums">{{ $today->format('M j, Y') }}</p>
                </div>
            </section>

            <section class="mb-8 grid gap-4 lg:grid-cols-2">
                <div class="rounded-2xl border {{ $activeEvent ? $typeStyles[$activeEvent['type']]['accent'] : 'border-slate-200 bg-white text-slate-700' }} p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-2xl">{{ $activeEvent ? $typeStyles[$activeEvent['type']]['icon'] : 'event_busy' }}</span>
                        <p class="text-xs font-black uppercase tracking-[0.2em]">{{ $activeEvent ? 'Happening Now' : 'No Event Today' }}</p>
                    </div>
                    <p class="mt-3 text-base font-extrabold leading-snug">{{ $activeEvent['title'] ?? 'Use the upcoming list to plan your next task.' }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 text-slate-700 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-2xl text-blue-600">notification_important</span>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Next Up</p>
                    </div>
                    <p class="mt-3 text-base font-extrabold leading-snug text-slate-900">{{ $nextEvent['title'] ?? 'Trimester complete' }}</p>
                    @if($nextEvent)
                        <p class="mt-1 font-['Manrope',Inter,sans-serif] text-sm font-bold text-slate-500 tabular-nums">{{ $nextEvent['date'] }} - in {{ (int) $nextEvent['daysUntil'] }} days</p>
                    @endif
                </div>
            </section>

            <section class="mb-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm font-bold text-slate-500">Trimester Start</p>
                        <span class="material-symbols-outlined rounded-xl bg-blue-50 p-2 text-blue-600">flag</span>
                    </div>
                    <p class="mt-4 font-['Manrope',Inter,sans-serif] text-2xl font-black text-slate-900 tabular-nums">Feb 28, 2026</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm font-bold text-slate-500">Deadlines</p>
                        <span class="material-symbols-outlined rounded-xl bg-rose-50 p-2 text-rose-600">assignment_late</span>
                    </div>
                    <p class="mt-4 text-2xl font-black text-slate-900">{{ $deadlineCount }} dates</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm font-bold text-slate-500">Holidays</p>
                        <span class="material-symbols-outlined rounded-xl bg-amber-50 p-2 text-amber-600">celebration</span>
                    </div>
                    <p class="mt-4 text-2xl font-black text-slate-900">{{ $holidayCount }} breaks</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm font-bold text-slate-500">Final Exam</p>
                        <span class="material-symbols-outlined rounded-xl bg-violet-50 p-2 text-violet-600">school</span>
                    </div>
                    <p class="mt-4 font-['Manrope',Inter,sans-serif] text-2xl font-black text-slate-900 tabular-nums">June 21 - 28</p>
                </div>
            </section>

            <section class="grid gap-8 xl:grid-cols-[290px_1fr]">
                <aside class="space-y-5">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="mb-4 text-xs font-black uppercase tracking-[0.24em] text-slate-400">Categories</p>
                        <div class="space-y-3">
                            @foreach($typeStyles as $type)
                                <div class="flex items-center justify-between gap-3 rounded-xl bg-slate-50 px-3 py-2">
                                    <div class="flex items-center gap-3">
                                        <span class="h-2.5 w-2.5 rounded-full {{ $type['dot'] }}"></span>
                                        <span class="text-sm font-bold text-slate-700">{{ $type['label'] }}</span>
                                    </div>
                                    <span class="material-symbols-outlined text-base text-slate-400">{{ $type['icon'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-900">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-2xl">info</span>
                            <p class="text-sm font-black uppercase tracking-[0.18em]">Notes</p>
                        </div>
                        <ul class="mt-4 space-y-3 text-sm font-semibold leading-6">
                            <li><strong>*</strong> Subject to change based on university policy.</li>
                            <li><strong>**</strong> Tentative dates.</li>
                            <li><strong>***</strong> Final dates will be announced later.</li>
                            <li><strong>****</strong> Religious holidays may vary based on the lunar calendar.</li>
                        </ul>
                    </div>
                </aside>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-slate-200 bg-white px-5 py-5 md:flex-row md:items-center md:justify-between md:px-7">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900">Trimester Timeline</h2>
                            <p class="mt-1 text-sm font-semibold text-slate-500">Scan by date, type, and current status.</p>
                        </div>
                        <div class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-extrabold text-slate-600">
                            <span class="material-symbols-outlined text-lg">event_note</span>
                            {{ $events->count() }} events
                        </div>
                    </div>

                    <div class="hidden lg:block">
                        <table class="w-full table-fixed">
                            <thead class="bg-slate-50 text-left text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                <tr>
                                    <th class="w-[220px] px-7 py-4">Date</th>
                                    <th class="w-[130px] px-4 py-4">Day</th>
                                    <th class="px-4 py-4">Event</th>
                                    <th class="w-[150px] px-7 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($events as $event)
                                    @php($style = $typeStyles[$event['type']])
                                    <tr class="{{ $event['isToday'] ? 'bg-blue-50/80' : ($event['isUpcoming'] ? 'bg-yellow-50/70' : $style['row']) }} transition-colors">
                                        <td class="px-7 py-5 align-top">
                                            <div class="flex items-start gap-3">
                                                <span class="mt-1 h-3 w-3 shrink-0 rounded-full {{ $event['isToday'] ? 'bg-[#003366] ring-4 ring-blue-100' : $style['dot'] }}"></span>
                                                <div>
                                                    <p class="font-['Manrope',Inter,sans-serif] font-black text-slate-900 tabular-nums">{{ $event['date'] }}</p>
                                                    <p class="mt-1 text-xs font-bold uppercase tracking-[0.16em] text-slate-400">{{ $style['label'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-5 align-top text-sm font-bold text-slate-500">{{ $event['day'] }}</td>
                                        <td class="px-4 py-5 align-top">
                                            <div class="flex items-start gap-3">
                                                <span class="material-symbols-outlined mt-0.5 text-xl {{ $style['iconText'] }}">{{ $style['icon'] }}</span>
                                                <p class="text-base font-bold leading-6 text-slate-800">{{ $event['title'] }}</p>
                                            </div>
                                        </td>
                                        <td class="px-7 py-5 align-top">
                                            @if($event['isToday'])
                                                <span class="inline-flex rounded-full bg-[#003366] px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-white">Today</span>
                                            @elseif($event['isUpcoming'])
                                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-yellow-800">Soon</span>
                                            @elseif($event['isPast'])
                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-slate-500">Done</span>
                                            @else
                                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-emerald-700">Upcoming</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divide-y divide-slate-100 lg:hidden">
                        @foreach($events as $event)
                            @php($style = $typeStyles[$event['type']])
                            <article class="{{ $event['isToday'] ? 'bg-blue-50/80' : ($event['isUpcoming'] ? 'bg-yellow-50/70' : 'bg-white') }} p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-['Manrope',Inter,sans-serif] text-lg font-black text-slate-900 tabular-nums">{{ $event['date'] }}</p>
                                        <p class="mt-1 text-sm font-bold text-slate-500">{{ $event['day'] }}</p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-black uppercase tracking-[0.12em] ring-1 {{ $style['pill'] }}">
                                        <span class="material-symbols-outlined text-base">{{ $style['icon'] }}</span>
                                        {{ $style['label'] }}
                                    </span>
                                </div>

                                <p class="mt-4 text-base font-bold leading-6 text-slate-800">{{ $event['title'] }}</p>

                                @if($event['isToday'] || $event['isUpcoming'])
                                    <p class="mt-4 inline-flex rounded-full {{ $event['isToday'] ? 'bg-[#003366] text-white' : 'bg-yellow-100 text-yellow-800' }} px-3 py-1 text-xs font-black uppercase tracking-[0.14em]">
                                        {{ $event['isToday'] ? 'Today' : 'Coming Soon' }}
                                    </p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </main>
</x-layout>
