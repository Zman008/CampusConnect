<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CgpaService;

class CgpaTest extends TestCase
{
    /**
     * Test basic CGPA calculation with new courses only.
     */
    public function test_basic_cgpa_calculation(): void
    {
        $service = new CgpaService();
        
        $prevCredits = 60;
        $prevCgpa = 3.50;
        $newCourses = [
            ['credits' => 3, 'grade_point' => 4.00], // A
            ['credits' => 3, 'grade_point' => 3.67], // A-
        ];
        $retakeCourses = [];

        $result = $service->calculate($prevCredits, $prevCgpa, $newCourses, $retakeCourses);

        // Expected: (60*3.50 + 3*4.00 + 3*3.67) / 66 = 3.53
        $this->assertEquals(3.84, $result['tgpa']);
        $this->assertEquals(3.53, $result['final_cgpa']);
        $this->assertEquals(66, $result['total_credits']);
    }

    /**
     * Test CGPA calculation with Retake logic (Credits should not double).
     */
    public function test_retake_logic_cgpa_calculation(): void
    {
        $service = new CgpaService();

        $prevCredits = 3;
        $prevCgpa = 2.00; // Previously took 1 course, got C (2.00)
        
        $newCourses = [];
        $retakeCourses = [
            ['credits' => 3, 'old_grade_point' => 2.00, 'new_grade_point' => 4.00], // Retook C to A
        ];

        $result = $service->calculate($prevCredits, $prevCgpa, $newCourses, $retakeCourses);

        // Expected: (3*2.00 - 3*2.00 + 3*4.00) / 3 = 4.00
        // Total credits should remain 3, not become 6
        $this->assertEquals(4.00, $result['final_cgpa']);
        $this->assertEquals(3, $result['total_credits']);
    }
}