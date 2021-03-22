<?php

use Illuminate\Support\Facades\Route;

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
		return array(
			array(
				"href" => "b",
				"name" => "Random"
			),
			array(
				"href" => "it",
				"name" => "Technology"
			),
			array(
				"href" => "sp",
				"name" => "Sports"
			)
		);
	});

	Route::get('/board/{board_href}', function ($board_href) {
		if ($board_href == 'b'){
		return array("href" => "dD", "name" => "test");}
		else {
			return array("href" => "dDa", "name" => "testaa");
		}
	});
});

Route::get('/{any}', function(){
    return view('larachan');
})->where('any', '.*');