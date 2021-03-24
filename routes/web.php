<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Entry;
use App\Models\Comment;

use App\Http\Controllers\BoardController;
use App\Http\Controllers\EntryController;

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
	Route::post('/entry', [EntryController::class, 'postEntry']);


	Route::get('/comment/{comment_id}', function ($comment_id) {
		return Comment::where('id', $comment_id)->first();
	});

	Route::post('/comment', function(Request $request){
		$comment = new Comment;
		$comment->body = $request->input('body');
		$comment->entry_id = $request->input('entry_id');
		$comment->save();

		$entry = $comment->entry;
		$entry->touch();
		$entry->save();

		return $comment;
	});
});

Route::get('/{any}', function(){
    return view('larachan');
})->where('any', '.*');