<?php

namespace Ogae;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

  protected $fillable = [
    'title', 'body', 'remote_id', 'remote_source', 'posted_at',
  ];

  protected $casts = [
    'posted_at' => 'datetime',
  ];

  public function song()
  {
    return $this->belongsTo(Song::class);
  }
}
