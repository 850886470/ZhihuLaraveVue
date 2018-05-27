<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/5/27
 * Time: 11:54
 */

namespace App\Repositories;


use App\User;

class UserRepository
{

    public function byId($id)
    {
        return User::find($id);
    }


}