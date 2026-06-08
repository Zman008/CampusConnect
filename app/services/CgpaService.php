<?php

namespace App\Services;

class CgpaService
{
    public function calculate(float $prevCredits, float $prevCgpa, array $newCourses, array $retakeCourses): array
    {
        $oldTotalPoints = $prevCredits * $prevCgpa;
        
        $currentTriPoints = 0;
        $currentTriCredits = 0;
        
        $newCreditsOnly = 0;
        $retakePointsAdjustment = 0;

        // 1. Process Fresh Courses
        foreach ($newCourses as $course) {
            $cr = $course['credits'] ?? 0;
            $gp = $course['grade_point'] ?? 0;
            
            $currentTriPoints += ($cr * $gp);
            $currentTriCredits += $cr;
            $newCreditsOnly += $cr;
        }

        // 2. Process Retake Courses
        foreach ($retakeCourses as $course) {
            $cr = $course['credits'] ?? 0;
            $oldGp = $course['old_grade_point'] ?? 0;
            $newGp = $course['new_grade_point'] ?? 0;

            $currentTriPoints += ($cr * $newGp);
            $currentTriCredits += $cr;
            
            // Logic: Subtract old points and prepare to add new points
            $retakePointsAdjustment -= ($cr * $oldGp);
        }

        // 3. Final Formulas
        $tgpa = $currentTriCredits > 0 ? ($currentTriPoints / $currentTriCredits) : 0;
        
        $finalTotalCredits = $prevCredits + $newCreditsOnly;
        $finalTotalPoints = $oldTotalPoints + $retakePointsAdjustment + $currentTriPoints;
        
        $finalCgpa = $finalTotalCredits > 0 ? ($finalTotalPoints / $finalTotalCredits) : 0;

        // Using round with PHP_ROUND_HALF_UP to be consistent with standard grading
        return [
            'tgpa' => round($tgpa, 2, PHP_ROUND_HALF_UP),
            'final_cgpa' => round($finalCgpa, 2, PHP_ROUND_HALF_UP),
            'total_credits' => $finalTotalCredits
        ];
    }
}