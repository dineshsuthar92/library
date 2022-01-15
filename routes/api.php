<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', ['uses' => 'ApiController@login', 'name' => 'login']);
Route::post('register', ['uses' => 'ApiController@register', 'name' => 'login']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user/profile', ['uses' => 'UserController@getProfile', 'name' => 'user.profile']);

    //books
    Route::get('books/{id?}', ['uses' => 'BookController@getBook']);
    Route::post('book/create', ['uses' => 'BookController@createABook']);
    Route::post('book/edit/{id}', ['uses' => 'BookController@editBook']);
    Route::get('book/delete/{id}', ['uses' => 'BookController@deleteBook']);

    //book transactions

    Route::post('rent-a-book', ['uses' => 'BookTransactionController@rentABook', 'name' => 'rent.book']);

    Route::post('return-a-book', ['uses' => 'BookTransactionController@returnABook', 'name' => 'return.book']);
});
