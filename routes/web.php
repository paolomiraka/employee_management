<?php
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Events\MessagePosted;

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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('home', 'HomeController@update_avatar');


Route::get('/users/showall', 'UserController@showAllUsers');
Route::get('/users/edit/{user}', 'UserController@edit');
Route::patch('/users/edit/{user}/update', 'UserController@update');
Route::delete('users/showall/delete/{user}', 'UserController@destroy');


Route::get('/departments/showall', 'DepartmentController@showAllDepartments');
// Route::get('/departments/edit/{department}', 'DepartmentController@edit');
// Route::patch('/departments/edit/{department}/update', 'DepartmentController@update');

//Chat route
Route::get('/chat', function(){
    return view('chat');
})->middleware('auth');

Route::get('/messages', function () {
    return App\Message::with('user')->get();
})->middleware('auth');

Route::post('/messages', function () {

    // Store the new message
    $user = Auth::user();
    $message = $user->messages()->create([
        'message' => request()->get('message')
    ]);
    // Announce that a new message has been posted
    broadcast(new MessagePosted($message, $user))->toOthers();
    return ['status' => 'OK'];
})->middleware('auth');

//Tree view routes
Route::post('/departments/add_dep', 'DepartmentController@add_tree');
