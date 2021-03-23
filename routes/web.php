<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Board;
use App\Models\Entry;
use App\Models\Comment;

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
	Route::get('/boards', function() {
		return Board::where('listed', true)->get();
	});

	Route::get('/board/{board_href}', function ($board_href) {
		return Board::where('href', $board_href)->first();
	});

	Route::get('/entries/{board_href}', function($board_href) {
		return Board::where('href', $board_href)->first()->entries;
	});

	Route::get('/entry/{entry_id}', function ($entry_id) {
		$entry = Entry::where('id', $entry_id)->first();

		$returnData = $entry;
		$returnData['comments'] = $entry['comments'];

		return $returnData;
	});

	Route::post('/entry', function(Request $request){

	});


	Route::get('/comment/{comment_id}', function ($comment_id) {
		return Comment::where('id', $comment_id)->first();
	});

	Route::post('/comment', function(Request $request){
		$comment = new Comment;
		$comment->body = $request->input('body');
		$comment->entry_id = $request->input('entry_id');
		$comment->save();
	});
});

Route::get('/{any}', function(){
    return view('larachan');
})->where('any', '.*');