<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function entry ()
	{
		return $this->belongsTo(Entry::class);
	}
}
