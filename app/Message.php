<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from_user_id','to_user_id','body',];

    protected $table = 'messages';

    protected function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }

    protected function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }
}
