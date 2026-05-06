<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\Broadcaster;

class CommunityMessage extends Model
{
    use HasFactory;

    protected $table = 'community_messages';

    protected $fillable = [
        'group_id',
        'user_id',
        'message',
    ];

    public function group()
    {
        return $this->belongsTo(CommunityGroup::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function broadcastOn()
    {
        return [new PrivateChannel('community.group.' . $this->group_id)];
    }
}
