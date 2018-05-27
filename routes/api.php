<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/topics',function (Request $request){
    $topics = \App\Topic::select(['id','name'])
        ->where('name','like','%'.$request->query('q').'%')
        ->get();

    return $topics;
})->middleware('api');

Route::post('/question/follower',function (Request $request){
    $user = Auth::guard('api')->user();
    if (!$user)
        abort(403);
    $followed = $user->followed($request->question);
    return response()->json(['followed'=>!!$followed]);
})->middleware('api');

Route::post('/question/follow',function (Request $request){
    $user = Auth::guard('api')->user();

    if (!$user)
        abort(403);

    $question = \App\Question::find($request->question);
    $followed = $user->follows()->where('question_id',$request->question)->first();

    if ($followed) {
        $question->decrement('followers_count');
        $followed->delete();
        return response()->json(['followed'=>false]);
    } else {
        $user->followThis($question->id);
        $question->increment('followers_count');
        return response()->json(['followed'=>true]);
    }


})->middleware('api');

Route::get('/user/followers/{id}','FollowersController@index');
Route::post('/user/follow','FollowersController@follow');

Route::post('/answer/{id}/votes/users','VotesController@users');
Route::post('/answer/vote','VotesController@vote');

Route::post('/message/store','MessagesController@store');
