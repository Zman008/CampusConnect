<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionBankFile extends Model
{
    protected $fillable = [
        'user_id',
        'course_code',
        'course_name',
        'semester',
        'term',
        'file_path',
        'original_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
