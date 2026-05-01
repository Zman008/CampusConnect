<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRoutine extends Model
{
    use HasFactory;

    // These columns can be filled by the application
    protected $fillable = [
        'course_code',
        'course_name',
        'day',
        'time_slot',
    ];
}