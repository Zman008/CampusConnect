<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityGroup extends Model
{
    use HasFactory;

    protected $table = 'community_groups';

    protected $fillable = [
        'name',
        'description',
    ];

    public function messages()
    {
        return $this->hasMany(CommunityMessage::class, 'group_id');
    }
}
