<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    /**
     * Get the room associated with the ChatMessage
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function room(): HasOne
    {
        return $this->hasOne(ChatRoom::class, 'id', 'chat_room_id');
    }


    /**
     * Get the user associated with the ChatMessage
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
