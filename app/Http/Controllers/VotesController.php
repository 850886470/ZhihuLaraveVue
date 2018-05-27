<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Auth;
use Illuminate\Http\Request;

class VotesController extends Controller
{

    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function users($answerId)
    {
        $user = Auth::guard('api')->user();

        if ($user->hasVotedFor($answerId))
        {
            return response()->json(['voted'=>true]);
        }

        return response()->json(['voted'=>false]);
    }

    public function vote()
    {
        $voted = Auth::guard('api')->user()->voteFor(request('answer'));
        $answer = $this->answer->byId(request('answer'));

        if (count($voted['attached'])) {

            $answer->increment('votes_count');
            return response()->json(['voted'=>true]);
        }

        $answer->decrement('votes_count');
        return response()->json(['voted'=>false]);
    }
}
