<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }

    public function board ()
	{
		return $this->belongsTo(Board::class);
	}
}
