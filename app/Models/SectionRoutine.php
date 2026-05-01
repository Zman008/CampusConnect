<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code', 'course_short_name', 'course_title', 'section', 'days', 
        'start_time', 'end_time', 'faculty_name'
    ];
}
