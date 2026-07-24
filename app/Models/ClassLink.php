<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassLink extends Model {
    protected $fillable = ['course_code', 'section', 'link_type', 'url', 'added_by'];

    public function user() {
        return $this->belongsTo(User::class, 'added_by');
    }
}