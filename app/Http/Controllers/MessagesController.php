<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    public function store()
    {
        $message = $this->message->create([
            'to_user_id'=>request('user'),
            'body'=>request('body'),
            'from_user_id'=>Auth::guard('api')->user()->id
        ]);

        if ($message)
            return response()->json(['status'=>true]);
        else
            return response()->json(['status'=>true]);
    }
}
