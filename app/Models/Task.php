<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title', 
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];
}