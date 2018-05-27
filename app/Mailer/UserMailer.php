<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/5/27
 * Time: 18:58
 */

namespace App\Mailer;

use Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = ['url'=>env('APP_URL'),'name'=>Auth::guard('api')->user()->name];
        $this->sendTo('zhihu_app_user_follow',$email,$data);
    }

    public function passwordReset($email,$token)
    {
        $data = [
            'url'=>route('password.reset', $token )
        ];

        $this->sendTo('zhihu_app_password_forget',$email,$data);
    }

    public function welcome(User $user)
    {
        $data = [
            'name'=>$user->name,
            'url'=>route('email.verify',['token'=>$user->confirmation_token]
            )];

        $this->sendTo('zhihu',$user->email,$data);
    }
}