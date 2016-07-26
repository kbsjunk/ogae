<?php

namespace Ogae;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
    'title', 'body', 'remote_id', 'remote_source', 'posted_at',
  ];

  protected $casts = [
    'posted_at' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function post()
  {
    return $this->belongsTo(Post::class);
  }
}
