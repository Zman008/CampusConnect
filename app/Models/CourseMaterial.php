<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    protected $fillable = [
        'user_id',
        'course_code',
        'course_name',
        'title',
        'type',
        'file_path',
        'file_name',
        'file_size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes < 1024)    return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'pdf'        => '📄',
            'slides'     => '📊',
            'assignment' => '📝',
            'book'       => '📗',
            default      => '📁',
        };
    }
}
