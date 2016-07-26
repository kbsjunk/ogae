<?php

namespace Ogae\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Ogae\Http\Requests;
use Ogae\Http\Controllers\Controller;

use Ogae\Post;
use Ogae\Song;
use Ogae\User;

use Auth;
use DB;

class PostsController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $posts = Post::with('song')->leftJoin('songs', 'posts.song_id', '=', 'songs.id')->orderByRaw('posts.song_id IS NULL')->orderBy('songs.final_points', 'desc')->orderBy('songs.semi_points', 'desc')->orderBy('posted_at', 'desc')->get();//->get();

    return view('posts.index', compact('posts'));
  }

  public function download()
  {
    $this->downloadWordpress();
    $this->downloadFacebook();
  }

  public function downloadWordpress()
  {
    $url = 'http://www.esccovers.com/category/song-review/feed/?paged=';
    for ($i=1; $i < 20; $i++) {
      try {
        $feed = \RSS::feed($url.$i);
      }
      catch (\Vinelab\Rss\Exceptions\InvalidFeedContentException $e) {
        continue;
      }

      foreach ($feed->articles() as $item) {
        $post = Post::with('song')->firstOrNew(['remote_id' => $item->guid, 'remote_source' => 'W']);
        $post->title = $item->title;
        $post->body = $item->description;
        $post->posted_at = \Carbon\Carbon::createFromFormat(\DateTime::RSS, $item->pubDate);

        if (!$post->song) {
          // if (preg_match('/^EUROVISION 2016.*SONG REVIEWS.*([A-Z]+)/', $post->body, $matches)) {
          if (preg_match('/^<p>Song \d+ ?: ([A-Z]+)/', $post->body, $matches)) {
            $country = strtolower($matches[1]);

            $song = Song::where('country', 'LIKE', $country.'%')->first();
            if ($song) {
              $post->song()->associate($song);
            }
          }
        }

        $post->save();
      }
    }

    return redirect()->route('admin.posts.index');

  }

  public function downloadFacebook()
  {
    $fb = app('facebook');
    $accessToken = Auth::user()->facebook_token;

    try {
      $response = $fb->get('/1492309797652242/feed?limit=200', $accessToken);

    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $feed = $response->getGraphList();

    foreach ($feed as $item) {

      if (!$item->getField('story')) {
        $post = Post::with('song')->firstOrNew(['remote_id' => $item->getField('id'), 'remote_source' => 'F']);
        $post->body = $item->getField('message') ?: $item->getField('story');
        $post->posted_at = $item->getField('updated_time');

        if (!$post->song) {
          if (preg_match('/^Song \d+ ?: ([A-Z]+)/', $post->body, $matches)) {
            $country = strtolower($matches[1]);

            $song = Song::where('country', 'LIKE', $country.'%')->first();
            if ($song) {
              $post->song()->associate($song);
            }
          }
        }

        $post->save();
      }

    }

    return redirect()->route('admin.posts.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }

  /**
  * Display the specified resource.
  *
  * @param  int  Post $post
  * @return \Illuminate\Http\Response
  */
  public function show(Post $post)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  Post $post
  * @return \Illuminate\Http\Response
  */
  public function edit(Post $post)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  Post $post
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Post $post)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  Post $post
  * @return \Illuminate\Http\Response
  */
  public function destroy(Post $post)
  {
    //
  }
}
