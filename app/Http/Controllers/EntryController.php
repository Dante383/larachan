<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Models\Entry;

class EntryController extends Controller
{
    public function getEntry ($entry_id) {
    	$entry = Entry::with('comments')->where('id', $entry_id)->firstOrFail();

		return $entry;
    }

    public function postEntry (Request $request) {
    	$request->validate([
    		'file' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
    		'title' => 'max:255',
    		'body' => 'required',
    		'board_id' => 'required'
    	]);

    	$entry = new Entry;

    	if ($request->file('file')) {
    		$file = $request->file('file');

    		$img = Image::make($file);

    		$imagePath = 'public/images/' . time() . '.' . $file->extension();
    		Storage::put($imagePath, $img->encode($file->extension()));

    		$thumbnail = $img->widen(250);

    		$thumbnailPath = 'public/images/' . time() . '_thumb.' . $file->extension();
    		Storage::put($thumbnailPath, $thumbnail->encode($file->extension()));

    		$entry->image_fullres = Storage::url($imagePath);
    		$entry->image_thumbnail = Storage::url($thumbnailPath);
    	}

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
