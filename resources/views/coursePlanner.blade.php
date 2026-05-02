<x-layout>
    <x-slot:title>Course Planner | CampusConnect</x-slot:title>

    <main class="flex-grow px-6 py-10">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-[#003366] mb-6">Course Planner</h1>

            <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold text-[#003366] mb-6">Exam Conflict Checker</h2>

                <div class="flex gap-4 mb-6">
                    <div class="flex-1 relative">
                        <input list="courses-list" id="courseInput" 
                            class="w-full bg-slate-50 border border-gray-200 rounded-lg px-4 py-3 outline-none focus:border-blue-500" 
                            placeholder="Search by Course Code or Name" autocomplete="off">
                        
                        <datalist id="courses-list">
                            @foreach($allCourses as $course)
                                <option value="{{ $course->course_code }} - {{ $course->course_name }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <button onclick="addCourse()" class="bg-[#003366] text-white px-6 py-3 rounded-lg hover:bg-blue-800 font-medium">
                        Add Course
                    </button>
                    <button onclick="clearAllRoutine()" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-medium">
                        Clear All
                    </button>
                    @auth
                    <button onclick="saveRoutine()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-medium">
                        Save Routine
                    </button>
                    @endauth
                </div>

                <div id="conflictAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <strong class="font-bold">Conflict Detected! </strong>
                    <span id="conflictMessage" class="block sm:inline"></span>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-900 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Course</th>
                                <th class="px-6 py-4 font-bold">Exam Day</th>
                                <th class="px-13 py-4 font-bold">Time Slot</th>
                                <th class="px-6 py-4 font-bold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="routineTableBody" class="divide-y divide-gray-100">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // 1. Pass the Laravel database collection directly to JavaScript!
        const databaseCourses = @json($allCourses);
        let mySelectedCourses = @json($userRoutines->toArray());
        const isLoggedIn = @auth true @else false @endauth;

        function addCourse() {
            const inputVal = document.getElementById('courseInput').value;
            const alertBox = document.getElementById('conflictAlert');
            const alertMessage = document.getElementById('conflictMessage');
            
            // Hide previous errors
            alertBox.classList.add('hidden');

            // Find the exact course in our database array using the course code
            const courseCode = inputVal.split(' - ')[0]; 
            const newCourse = databaseCourses.find(c => c.course_code === courseCode);

            if (!newCourse) return; // Stop if they typed invalid garbage

            // 2. CHECK FOR EXAM CONFLICTS
            const conflict = mySelectedCourses.find(c => c.day === newCourse.day && c.time_slot === newCourse.time_slot);

            if (conflict) {
                // Uh oh! Show the error and stop!
                alertMessage.innerText = `${newCourse.course_code} conflicts with ${conflict.course_code} on Day ${newCourse.day} at ${newCourse.time_slot}.`;
                alertBox.classList.remove('hidden');
                return;
            }

            // Prevent adding the exact same course twice
            if (mySelectedCourses.find(c => c.id === newCourse.id)) return;

            // 3. No conflicts? Add it to our list and render the table!
            mySelectedCourses.push(newCourse);
            document.getElementById('courseInput').value = ''; // clear input
            renderTable();
        }

        function removeCourse(courseId) {
            courseId = parseInt(courseId);
            mySelectedCourses = mySelectedCourses.filter(c => parseInt(c.id) !== courseId);
            document.getElementById('conflictAlert').classList.add('hidden'); // clear errors
            renderTable();
            if (isLoggedIn) saveRoutine();
        }

        // Helper to convert 1,2,3 into readable times
        function getTimeString(slot) {
            const slots = {
                1: "T1 (9:00 - 11:00 AM)",
                2: "T2 (11:30 - 1:30 PM)",
                3: "T3 (2:00 - 4:00 PM)"
            };
            return slots[slot] || "Unknown";
        }
        
        function renderTable() {
            const tbody = document.getElementById('routineTableBody');
            tbody.innerHTML = ''; 

            mySelectedCourses.sort((a, b) => a.day - b.day || a.time_slot - b.time_slot).forEach(course => {
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">${course.course_code} <br><span class="text-xs text-gray-500">${course.course_name}</span></td>
                        <td class="px-10 py-4">Day ${course.day}</td>
                        <td class="px-6 py-4 font-semibold">${getTimeString(course.time_slot)}</td> 
                        <td class="px-6 py-4 text-right">
                            <button onclick="removeCourse(${course.id})" class="text-red-500 hover:text-red-700 font-medium">Remove</button>
                        </td>
                    </tr>
                `;
            });
        }

        function saveRoutine() {
            const routineIds = mySelectedCourses.map(c => c.id);
            fetch('/course-planner/save', {
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
            if (confirm('Are you sure you want to clear all courses? This action cannot be undone.')) {
                mySelectedCourses = [];
                document.getElementById('conflictAlert').classList.add('hidden');
                renderTable();
                if (isLoggedIn) saveRoutine();
            }
        }

        // Initialize table on load
        renderTable();
    </script>
</body>
</html>

</x-layout>