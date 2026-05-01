<?php

namespace Database\Seeders;

use App\Models\ExamRoutine;
use Illuminate\Database\Seeder;

class ExamRoutineSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // DAY 1
            ['course_code' => 'CSE 1111', 'course_name' => 'Structured Programming Language', 'day' => 1, 'time_slot' => 1],
            ['course_code' => 'CSE 4509', 'course_name' => 'Operating Systems', 'day' => 1, 'time_slot' => 1], // CONFLICT TEST
            ['course_code' => 'CSE 2215', 'course_name' => 'Data Structures', 'day' => 1, 'time_slot' => 2],
            ['course_code' => 'CSE 3411', 'course_name' => 'System Analysis and Design', 'day' => 1, 'time_slot' => 3],

            // DAY 2
            ['course_code' => 'CSE 1115', 'course_name' => 'Object Oriented Programming', 'day' => 2, 'time_slot' => 1],
            ['course_code' => 'CSE 2231', 'course_name' => 'Digital Logic Design', 'day' => 2, 'time_slot' => 1], // CONFLICT TEST
            ['course_code' => 'CSE 2211', 'course_name' => 'Algorithms', 'day' => 2, 'time_slot' => 2],
            ['course_code' => 'CSE 3313', 'course_name' => 'Computer Architecture', 'day' => 2, 'time_slot' => 3],

            // DAY 3
            ['course_code' => 'CSE 3521', 'course_name' => 'Database Management Systems', 'day' => 3, 'time_slot' => 1],
            ['course_code' => 'CSE 4325', 'course_name' => 'Computer Networks', 'day' => 3, 'time_slot' => 2],
            ['course_code' => 'CSE 4123', 'course_name' => 'Artificial Intelligence', 'day' => 3, 'time_slot' => 3],

            // DAY 4
            ['course_code' => 'CSE 4811', 'course_name' => 'Cyber Security', 'day' => 4, 'time_slot' => 1],
            ['course_code' => 'CSE 2217', 'course_name' => 'Microprocessors and Microcontrollers', 'day' => 4, 'time_slot' => 2],
            ['course_code' => 'CSE 4711', 'course_name' => 'Machine Learning', 'day' => 4, 'time_slot' => 3],

            // DAY 5
            ['course_code' => 'CSE 4511', 'course_name' => 'Compiler Design', 'day' => 5, 'time_slot' => 1],
            ['course_code' => 'CSE 3421', 'course_name' => 'Software Engineering', 'day' => 5, 'time_slot' => 2],
            ['course_code' => 'CSE 1110', 'course_name' => 'Introduction to Computer Systems', 'day' => 5, 'time_slot' => 3],

            // DAY 6
            ['course_code' => 'CSE 4611', 'course_name' => 'Computer Graphics', 'day' => 6, 'time_slot' => 1],
            ['course_code' => 'CSE 4327', 'course_name' => 'Network Security', 'day' => 6, 'time_slot' => 2],
            ['course_code' => 'CSE 4133', 'course_name' => 'Pattern Recognition', 'day' => 6, 'time_slot' => 3],

            // DAY 7
            ['course_code' => 'CSE 4999', 'course_name' => 'Capstone Project I', 'day' => 7, 'time_slot' => 1],
            ['course_code' => 'CSE 4521', 'course_name' => 'Simulation and Modeling', 'day' => 7, 'time_slot' => 2],
            ['course_code' => 'CSE 4125', 'course_name' => 'Data Mining', 'day' => 7, 'time_slot' => 3],
        ];

        foreach ($data as $item) {
            \App\Models\ExamRoutine::create($item);
        }
    }
}