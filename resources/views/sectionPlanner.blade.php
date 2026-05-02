<x-layout>
    <x-slot:title>Section Planner | CampusConnect</x-slot:title>

    
    <main class="flex-grow px-6 py-10">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-[#003366] mb-6">Course Planner</h1>

            <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold text-[#003366] mb-6">Class Section Planner</h2>

                <div class="flex gap-4 mb-6">
                    <div class="flex-1 relative">
                        <input list="sections-list" id="sectionInput" 
                            class="w-full bg-slate-50 border border-gray-200 rounded-lg px-4 py-3 outline-none focus:border-blue-500" 
                            placeholder="Search by Course Code, Name, Section, Time or Faculty" autocomplete="off">
                        
                        <datalist id="sections-list">
                            @foreach($sections as $section)
                                <option value="{{ $section->course_code }} - {{ $section->course_title }} [Sec {{ $section->section }}]">
                                    {{ $section->course_short_name }} | {{ $section->days }} | {{ \Carbon\Carbon::parse($section->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($section->end_time)->format('h:i A') }} | {{ $section->faculty_name }}
                                </option>
                            @endforeach
                        </datalist>
                    </div>
                    <button onclick="addSection()" class="bg-[#003366] text-white px-6 py-3 rounded-lg hover:bg-blue-800 font-medium whitespace-nowrap">
                        Add Section
                    </button>
                    <button onclick="clearAllRoutine()" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-medium whitespace-nowrap">
                        Clear All
                    </button>
                    @auth
                    <button onclick="saveRoutine()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-medium whitespace-nowrap">
                        Save Routine
                    </button>
                    @endauth
                </div>

                <div id="conflictAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <strong class="font-bold">Time Conflict! </strong>
                    <span id="conflictMessage" class="block sm:inline"></span>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-900 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Course</th>
                                <th class="px-6 py-4 font-bold text-center">Faculty</th>
                                <th class="px-6 py-4 font-bold text-center">Schedule</th>
                                <th class="px-6 py-4 font-bold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="routineTableBody" class="divide-y divide-gray-100">
                            </tbody>
                    </table>
                </div>
        </div>
    </main>

    <script>
        const databaseSections = @json($sections);
        let mySelectedSections = @json($userRoutines->toArray());
        const isLoggedIn = @auth true @else false @endauth;

        // Helper to format "13:30:00" to "01:30 PM"
        function formatTime(timeString) {
            let [hour, minute] = timeString.split(':');
            let ampm = hour >= 12 ? 'PM' : 'AM';
            hour = hour % 12 || 12; // Convert 0 to 12
            return `${hour}:${minute} ${ampm}`;
        }

        // Helper to check if two day strings share any days (e.g. "Sat, Tue" and "Sun, Tue" -> True)
        function doDaysOverlap(days1, days2) {
            const arr1 = days1.split(',').map(d => d.trim());
            const arr2 = days2.split(',').map(d => d.trim());
            return arr1.some(d => arr2.includes(d));
        }

        // Helper to check if time ranges overlap
        function doTimesOverlap(start1, end1, start2, end2) {
            return (start1 < end2) && (end1 > start2);
        }

        function addSection() {
            const inputVal = document.getElementById('sectionInput').value;
            const alertBox = document.getElementById('conflictAlert');
            const alertMessage = document.getElementById('conflictMessage');
            alertBox.classList.add('hidden');

            // Extract Course Code and Section from the input value string
            const match = inputVal.match(/(.+?)\s-\s.+?\[Sec\s(.+)\]/);
            if (!match) return; 

            const courseCode = match[1];
            const sectionName = match[2];

            const newSection = databaseSections.find(s => s.course_code === courseCode && s.section === sectionName);
            if (!newSection) return;

            // 1. Check for Conflicts
            for (let existing of mySelectedSections) {
                // If the days overlap AND the times overlap, we have a conflict!
                if (doDaysOverlap(newSection.days, existing.days) && doTimesOverlap(newSection.start_time, newSection.end_time, existing.start_time, existing.end_time)) {
                    alertMessage.innerText = `${newSection.course_code} (Sec ${newSection.section}) conflicts with ${existing.course_code} (Sec ${existing.section}).`;
                    alertBox.classList.remove('hidden');
                    return;
                }
                
                // Prevent adding the same course twice (even different sections)
                if (existing.course_code === newSection.course_code) {
                    alertMessage.innerText = `You have already added a section for ${newSection.course_code}.`;
                    alertBox.classList.remove('hidden');
                    return;
                }
            }

            mySelectedSections.push(newSection);
            document.getElementById('sectionInput').value = '';
            renderTable();
        }

        function removeSection(id) {
            id = parseInt(id);
            mySelectedSections = mySelectedSections.filter(s => parseInt(s.id) !== id);
            document.getElementById('conflictAlert').classList.add('hidden');
            renderTable();
            if (isLoggedIn) saveRoutine();
        }

        function renderTable() {
            const tbody = document.getElementById('routineTableBody');
            tbody.innerHTML = ''; 

            mySelectedSections.forEach(sec => {
                const timeStr = `${formatTime(sec.start_time)} - ${formatTime(sec.end_time)}`;
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">${sec.course_code}</span>
                            <span class="ml-2 inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Sec ${sec.section}</span>
                            <br><span class="text-xs text-gray-500">${sec.course_title}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700 text-center">
                            ${sec.faculty_name}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-semibold text-gray-800">${sec.days}</span><br>
                            <span class="text-xs text-gray-500">${timeStr}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="removeSection(${sec.id})" class="text-red-500 hover:text-red-700 font-medium">Remove</button>
                        </td>
                    </tr>
                `;
            });
        }

        function saveRoutine() {
            const routineIds = mySelectedSections.map(s => s.id);
            fetch('/section-planner/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ routines: routineIds })
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error('Error:', error));
        }

        function clearAllRoutine() {
            if (confirm('Are you sure you want to clear all sections? This action cannot be undone.')) {
                mySelectedSections = [];
                document.getElementById('conflictAlert').classList.add('hidden');
                renderTable();
                if (isLoggedIn) saveRoutine();
            }
        }

        // Initialize table on load
        renderTable();
    </script>

</x-layout>