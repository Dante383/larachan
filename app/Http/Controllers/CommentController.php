<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;

class CommentController extends Controller
{
    public function getComment ($comment_id) {
    	return Comment::where('id', $comment_id)->first();
    }

    public function postComment (Request $request) {
    	$comment = new Comment;
		$comment->body = $request->input('body');
		$comment->entry_id = $request->input('entry_id');
		$comment->save();

		$entry = $comment->entry;
		$entry->touch();
		$entry->save();

		return $comment;
    }
}
