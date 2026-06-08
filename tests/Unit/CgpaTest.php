<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CgpaService;

class CgpaTest extends TestCase
{
    public function test_basic_cgpa_calculation(): void
    {
        $service = new CgpaService();
        
        $prevCredits = 60;
        $prevCgpa = 3.50;
        $newCourses = [
            ['credits' => 3, 'grade_point' => 4.00], 
            ['credits' => 3, 'grade_point' => 3.67], 
        ];
        $retakeCourses = [];

        $result = $service->calculate($prevCredits, $prevCgpa, $newCourses, $retakeCourses);

        // (60*3.5 + 3*4.0 + 3*3.67) / 66 = 3.5304... -> 3.53
        $this->assertEquals(66, $result['total_credits']);
        $this->assertEquals(3.53, $result['final_cgpa']);
    }

    public function test_retake_logic_cgpa_calculation(): void
    {
        $service = new CgpaService();

        $prevCredits = 3;
        $prevCgpa = 2.00; // Got a C (2.00) in 1 course before
        
        $newCourses = [];
        $retakeCourses = [
            ['credits' => 3, 'old_grade_point' => 2.00, 'new_grade_point' => 4.00], // Retook to A
        ];

        $result = $service->calculate($prevCredits, $prevCgpa, $newCourses, $retakeCourses);

        // Final Points: (3*2.0) - (3*2.0) + (3*4.0) = 12
        // Final Credits: 3 (Should not increase)
        // 12 / 3 = 4.00
        $this->assertEquals(3, $result['total_credits']);
        $this->assertEquals(4.00, $result['final_cgpa']);
    }
}