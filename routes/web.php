<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','QuestionsController@index');

Auth::routes();

Route::get('email/verify/{token}',[
    'as'=>'email.verify',
    'uses'=>'EmailController@verify'
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions','QuestionsController',[
    'names'=>[
        'create'=>'question.create',
        'show'=>'question.show',
    ]
]);

Route::get('/test',function (){
    return view('test.index');
});

Route::post('questions/{question}/answer','AnswersController@store');
Route::get('question/{question}/follow','QuestionFollowController@follow');
Route::get('notifications','NotificationsController@index');