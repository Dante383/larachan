<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Models\Comment;

class CommentController extends Controller
{
    public function getComment ($comment_id) {
    	return Comment::where('id', $comment_id)->first();
    }

    public function postComment (Request $request) {
    	$request->validate([
    		'file' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
    		'title' => 'max:255',
    		'body' => 'required'
    	]);

    	$comment = new Comment;

    	if ($request->file('file')) {
    		$file = $request->file('file');

    		$img = Image::make($file);

    		$imagePath = 'public/images/' . time() . '.' . $file->extension();
    		Storage::put($imagePath, $img->encode($file->extension()));

    		$thumbnail = $img->widen(250);

    		$thumbnailPath = 'public/images/' . time() . '_thumb.' . $file->extension();
    		Storage::put($thumbnailPath, $thumbnail->encode($file->extension()));

    		$comment->image_fullres = Storage::url($imagePath);
    		$comment->image_thumbnail = Storage::url($thumbnailPath);
    	}

		$comment->body = $request->input('body');
		$comment->entry_id = $request->input('entry_id');
		$comment->save();

		$entry = $comment->entry;
		$entry->touch();
		$entry->save();

		return $comment;
    }
}
