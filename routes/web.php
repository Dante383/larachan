<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\BoardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\CommentController;

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

Route::prefix('api')->group(function(){
	Route::get('/boards', [BoardController::class, 'getBoards']);
	Route::get('/board/{board_href}', [BoardController::class, 'getBoard']);
	Route::get('/board/{board_href}/entries', [BoardController::class, 'getBoardEntries']);

	Route::get('/entry/{entry_id}', [EntryController::class, 'getEntry']);
	Route::delete('/entry/{entry_id}', [EntryController::class, 'deleteEntry']);
	Route::post('/entry', [EntryController::class, 'postEntry']);

	Route::get('/comment/{comment_id}', [CommentController::class, 'getComment']);
	Route::post('/comment', [CommentController::class, 'postComment']);
});

Route::get('/{any}', function(){
    return view('larachan');
})->where('any', '.*');