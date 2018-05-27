<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/5/27
 * Time: 18:58
 */

namespace App\Mailer;

use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    public function sendTo($template, $email, array $data)
    {

        $content = new SendCloudTemplate($template,$data);

        Mail::raw($content,function ($message) use ($email)
        {
            $message->from('850886470@qq.com','Studying Laravel');
            $message->to($email);
        });
    }
}