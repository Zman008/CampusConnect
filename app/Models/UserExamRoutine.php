<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamRoutine extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'exam_routine_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examRoutine()
    {
        return $this->belongsTo(ExamRoutine::class);
    }
}