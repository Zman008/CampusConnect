<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     * added 'description' and 'due_date' to the fillable array.
     */
    protected $fillable = [
        'user_id',
        'title', 
        'description',
        'due_date',
        'is_completed',
    ];

    /**
     * The attributes that should be cast.
     * added 'due_date' to cast it as a date object for easy formatting.
     */
    protected $casts = [
        'is_completed' => 'boolean',
        'due_date' => 'date',
    ];
}