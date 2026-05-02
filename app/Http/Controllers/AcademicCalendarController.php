<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcademicCalendarController extends Controller
{
    public function index()
    {
        $academicCalendar = [
            [
                'date' => 'Feb 23 - 25, 2026',
                'day' => 'Mon - Wed',
                'event' => 'Course Advising & Registration',
                'note' => '',
            ],
            [
                'date' => 'Feb 25, 2026',
                'day' => 'Wed',
                'event' => 'Last day of Course Advising & Registration without Fine',
                'note' => '',
            ],
            [
                'date' => 'Feb 28, 2026',
                'day' => 'Sat',
                'event' => 'Classes Begin',
                'note' => '',
            ],
            [
                'date' => 'Mar 2, 2026',
                'day' => 'Mon',
                'event' => 'Last day to drop course(s) with 100% adjustable refund',
                'note' => '',
            ],
            [
                'date' => 'Mar 7, 2026',
                'day' => 'Sat',
                'event' => 'Last day to apply for Grade Change of a course (if any) of Fall 2025 Trimester.',
                'note' => 'Note: No application will be considered after the deadline.',
            ],
            [
                'date' => 'Mar 9, 2026',
                'day' => 'Mon',
                'event' => 'Last day to drop course(s) with 50% adjustable refund',
                'note' => '',
            ],
            [
                'date' => 'Mar 10, 2026',
                'day' => 'Tue',
                'event' => 'Last day of Grade Submission for Project/ Thesis (Final Year Design Project/ Internship)',
                'note' => '',
            ],
            [
                'date' => 'Mar 15, 2026',
                'day' => 'Sun',
                'event' => 'Last day of Course Advising & Registration with a Fine of Tk. 500/-',
                'note' => '',
            ],
            [
                'date' => 'Mar 17 – 27, 2026',
                'day' => 'Tue - Fri',
                'event' => 'Holiday: Jumu’atul-Widaa / Shab-e-Qad’r / Eid-ul-Fit’r / Independence Day of Bangladesh',
                'note' => '',
            ],
            [
                'date' => 'Mar 31, 2026',
                'day' => 'Tue',
                'event' => 'Last day of Grade Submission of Incomplete Grades of Fall 2025 Trimester by concerned Department/Program Office',
                'note' => '',
            ],
            [
                'date' => 'Apr 12, 2026',
                'day' => 'Sun',
                'event' => 'Last date of 1st installment',
                'note' => '',
            ],
            [
                'date' => 'Apr 13, 2026',
                'day' => 'Mon',
                'event' => 'Make-up class: Regular Tuesday Classes',
                'note' => '',
            ],
            [
                'date' => 'Apr 14, 2026',
                'day' => 'Tue',
                'event' => 'Holiday: Bangla New Year',
                'note' => '',
            ],
            [
                'date' => 'Apr 18 - 24, 2026',
                'day' => 'Sat - Fri',
                'event' => 'Mid-Term Exam',
                'note' => '',
            ],
            [
                'date' => 'Apr 25, 2026',
                'day' => 'Sat',
                'event' => 'Regular Tuesday Classes',
                'note' => '',
            ],
            [
                'date' => 'Apr 26, 2026',
                'day' => 'Sun',
                'event' => 'Regular Wednesday Classes',
                'note' => '',
            ],
            [
                'date' => 'May 1, 2026',
                'day' => 'Fri',
                'event' => 'Holiday: Buddha Purnima and May Day',
                'note' => '',
            ],
            [
                'date' => 'May 4, 2026',
                'day' => 'Mon',
                'event' => 'Last Date for Course Withdrawal',
                'note' => '',
            ],
            [
                'date' => 'May 12, 2026',
                'day' => 'Tue',
                'event' => 'Last date of 2nd Installment',
                'note' => '',
            ],
            [
                'date' => 'May 26 – Jun 05, 2026',
                'day' => 'Tue - Fri',
                'event' => 'Holiday: Eid-ul-Adha',
                'note' => '',
            ],
            [
                'date' => 'Jun 14, 2026',
                'day' => 'Sun',
                'event' => 'Last date of 3rd installment',
                'note' => '',
            ],
            [
                'date' => 'Jun 18 - 20, 2026',
                'day' => 'Thu - Sat',
                'event' => 'Classes will remain suspended for Exam preparation',
                'note' => '',
            ],
            [
                'date' => 'Jun 21 - 28, 2026',
                'day' => 'Sun - Sun',
                'event' => 'Final Exam',
                'note' => '',
            ],
            [
                'date' => 'Jun 26, 2026',
                'day' => 'Fri',
                'event' => 'Holiday: Ashura',
                'note' => '',
            ],
            [
                'date' => 'Jul 2, 2026',
                'day' => 'Thu',
                'event' => 'Last date of Grade Submission (including Self-Study courses)',
                'note' => '',
            ],
        ];

        return view('academic_calendar', compact('academicCalendar'));
    }
}
