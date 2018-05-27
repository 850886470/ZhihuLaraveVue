<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/5/27
 * Time: 11:54
 */

namespace App\Repositories;


use App\Answer;
use App\Topic;

class AnswerRepository
{
    public function byIdWithTopics($id)
    {
        return Answer::where('id',$id)->with('topics')->first();
    }

    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    public function byId($id)
    {
        return Answer::find($id);
    }

    public function getQuestionsFeed()
    {
        return Answer::published()->latest('updated_at')->with('user')->get();
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function($topic)
        {

            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }

            $newTopic = Topic::create([
                'name'=>$topic,
                'questions_count'=>1
            ]);

            return $newTopic->id;
        })->toArray();
    }
}