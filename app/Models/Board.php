<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
	public function entries()
	{
		return $this->hasMany(Entry::class);
	}
}
