<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\StoreAnswerRequest;

class AnswersController extends Controller
{

    protected $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function store(StoreAnswerRequest $request,$question)
    {
        $answer = $this->answerRepository->create([
            'question_id'=>$question,
            'user_id'=>Auth::id(),
            'body'=>$request->body,
        ]);

        $answer->question()->increment('answers_count');

        return back();
    }
}
