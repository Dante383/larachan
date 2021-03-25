<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entry;

class EntryController extends Controller
{
    public function getEntry ($entry_id) {
    	$entry = Entry::with('comments')->where('id', $entry_id)->firstOrFail();

		return $entry;
    }

    public function postEntry (Request $request) {
    	$entry = new Entry;
		$entry->title = $request->input('title');
		$entry->body = $request->input('body');
		$entry->edit_key = $request->input('edit_key');
		$entry->board_id = $request->input('board_id');
		$entry->save();

		return $entry;
    }

    public function deleteEntry ($entry_id, Request $request) {
    	$entry = Entry::where('id', $entry_id)->firstOrFail();

    	if ($entry->edit_key === $request->input('edit_key')) {
    		$entry->delete();
    		return;
    	}

    	return abort(401);
    }
}
