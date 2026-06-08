<?php

namespace App\Services;

class CgpaService
{
    /**
     * Calculate Trimester GPA and Final CGPA based on UIU Retake Logic.
     */
    public function calculate(float $prevCredits, float $prevCgpa, array $newCourses, array $retakeCourses): array
    {
        $totalPointsAccumulated = $prevCredits * $prevCgpa;
        $trimesterPoints = 0;
        $trimesterCredits = 0;
        $netNewCredits = 0;
        $retakePointDifference = 0;

        // Process New Courses
        foreach ($newCourses as $course) {
            $cr = $course['credits'] ?? 0;
            $gr = $course['grade_point'] ?? 0;
            $trimesterPoints += ($cr * $gr);
            $trimesterCredits += $cr;
            $netNewCredits += $cr;
        }

        // Process Retake Courses
        foreach ($retakeCourses as $course) {
            $cr = $course['credits'] ?? 0;
            $oldG = $course['old_grade_point'] ?? 0;
            $newG = $course['new_grade_point'] ?? 0;

            $trimesterPoints += ($cr * $newG);
            $trimesterCredits += $cr;
            
            // Logic: Subtract old points from history and add new points
            $retakePointDifference += ($cr * ($newG - $oldG));
        }

        // Calculation Formulas
        $tgpa = $trimesterCredits > 0 ? ($trimesterPoints / $trimesterCredits) : 0;
        $finalTotalCredits = $prevCredits + $netNewCredits;
        
        $finalCgpa = $finalTotalCredits > 0 
            ? ($totalPointsAccumulated + ($trimesterPoints - ($trimesterCredits - $netNewCredits) * 0) + ($retakePointDifference - ($trimesterPoints - ($trimesterPoints - $retakePointDifference)))) / $finalTotalCredits
            : 0;

        // Simplified Result for Unit Test purposes
        $finalCgpa = $finalTotalCredits > 0 
            ? ($totalPointsAccumulated + ($trimesterPoints - ($trimesterCredits - $netNewCredits) * 0) + $retakePointDifference - ($trimesterPoints - ($trimesterPoints - $retakePointDifference))) / $finalTotalCredits
            : 0;
            
        // Final CGPA = (Old Total Points + Net Gain) / Final Total Credits
        $finalCgpa = $finalTotalCredits > 0 ? ($totalPointsAccumulated + ($trimesterPoints - ($trimesterCredits - $netNewCredits) * 0) + $retakePointDifference) / $finalTotalCredits : 0;

        return [
            'tgpa' => round($tgpa, 2),
            'final_cgpa' => round($finalCgpa, 2),
            'total_credits' => $finalTotalCredits
        ];
    }
}