<?php

namespace Database\Seeders;

use App\Models\SectionRoutine;
use Illuminate\Database\Seeder;

class SectionRoutineSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // CSE 1111: Two different sections
            ['course_code' => 'CSE 1111','course_short_name' => 'SPL', 'course_title' => 'Structured Programming Language', 'section' => 'A', 'days' => 'Sat, Tue', 'start_time' => '08:30:00', 'end_time' => '09:50:00', 'faculty_name' => 'Fahmid Al Rifat'],
            ['course_code' => 'CSE 1111','course_short_name' => 'SPL', 'course_title' => 'Structured Programming Language', 'section' => 'B', 'days' => 'Sun, Wed', 'start_time' => '10:00:00', 'end_time' => '11:10:00', 'faculty_name' => 'Fahmid Al Rifat'],
            
            // CSE 1112 (Lab for SPL): 2.5 hours on a single day
            ['course_code' => 'CSE 1112','course_short_name' => 'SPL Lab', 'course_title' => 'Structured Programming Language Lab', 'section' => 'A', 'days' => 'Sat', 'start_time' => '11:00:00', 'end_time' => '13:30:00', 'faculty_name' => 'Fahmid Al Rifat'],
            
            // Operating Systems
            ['course_code' => 'CSE 4509', 'course_short_name' => 'OS', 'course_title' => 'Operating Systems', 'section' => 'C', 'days' => 'Sat, Tue', 'start_time' => '12:30:00', 'end_time' => '13:50:00', 'faculty_name' => 'Mr. Smith'],
            
            // Conflict Test: This overlaps with CSE 4509 on Tuesdays!
            ['course_code' => 'CSE 2215', 'course_short_name' => 'DSA', 'course_title' => 'Data Structures', 'section' => 'D', 'days' => 'Sun, Tue', 'start_time' => '13:00:00', 'end_time' => '14:20:00', 'faculty_name' => 'Mr. Bob'],
        ];

        foreach ($data as $item) {
            SectionRoutine::create($item);
        }
    }
}