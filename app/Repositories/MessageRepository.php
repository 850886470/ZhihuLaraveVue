<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/5/27
 * Time: 11:54
 */

namespace App\Repositories;


use App\Message;

class MessageRepository
{

    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    public function byId($id)
    {
        return Message::find($id);
    }

}