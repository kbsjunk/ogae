<?php

namespace Ogae;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public function posts()
    {
      return $this->hasMany(Post::class);
    }
}
