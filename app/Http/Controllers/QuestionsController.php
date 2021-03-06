<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;

class QuestionsController extends Controller
{

    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.make');
    }

    /**
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreQuestionRequest $request)
    {
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $data = [
            'title'=>$request->title,
            'body'=>$request->body,
            'user_id'=>Auth::id(),
        ];

        $question = $this->questionRepository->create($data);
        $question->topics()->attach($topics);

        return redirect()->route('question.show',[$question->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);

        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);

        if (Auth::user()->owns($question))
            return view('questions.edit',compact('question'));

        return back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {

        $question = $this->questionRepository->byId($id);

        if (!Auth::user()->owns($question))
            return view('questions.show',compact('question'));

        $question->update([
            'title'=>$request->title,
            'body'=>$request->body,
        ]);

        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $question->topics()->sync($topics);

        return view('questions.show',compact('question'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);

        if (Auth::user()->owns($question)) {
            $question->delete();
            return redirect('/');
        }

        abort('403','Forbidden');


    }


}
