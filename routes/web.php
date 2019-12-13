<?php

use App\Models\Article;
use App\Models\User;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/article', function () {
    $users = User::all();
    dd($users->toArray());
    $users->each(function ($user) {
       if($user->events->isNotEmpty()) {
           dd($user->toArray());
       }
    });

});
