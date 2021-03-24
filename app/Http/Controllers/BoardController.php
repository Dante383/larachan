<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

class BoardController extends Controller
{
	// if $listed is false, this will also return unlisted boards
    public function getBoards ($listed=true) {
    	return Board::where('listed', $listed)->get();
    }

    public function getBoard ($board_href) {
    	return Board::where('href', $board_href)->first();
    }

    public function getBoardEntries ($board_href) {
		return Board::where('href', $board_href)->first()->entries()->orderByDesc('updated_at')->get();
    }
}
