<?php

use Illuminate\Support\Facades\Route;
use App\Models\Board;

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

	Route::get('/entry/{entry_id}', function ($entry_id) {
		return array(
			"id" => 18546313,
			"created_at" => "03/22/21(Mon)19:57:13",
			"title" => "Topic topic",
			"body" => "mmmm",
			"image" => array(
				"thumbnail" => "https://i.4cdn.org/b/16166182712s.jpg",
				"fullres" => "https://i.4cdn.org/b/16164382712.png"
			),
			"comments" => [7312, 5482, 4582, 54825]
		);
	});

	Route::get('/comment/{comment_id}', function ($entry_id) {
		return array(
			"id" => 7312,
			"created_at" => "03/22/21(Mon)19:57:13",
			"body" => "this is an example comment",
			"image" => array(
				"thumbnail" => "https://i.4cdn.org/b/16164359222s.jpg",
				"fullres" => "https://i.4cdn.org/b/16164359222.jpg"
			),
			"parent_id" => 18546313
		);
	});
});

Route::get('/{any}', function(){
    return view('larachan');
})->where('any', '.*');