<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = [];

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function lastMessage() {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function otherUser(User $authUser) {
        return $this->users
            ->where('id', '!=', $authUser->id)
            ->first();
    }
}