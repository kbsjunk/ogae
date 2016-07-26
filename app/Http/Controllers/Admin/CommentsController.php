<?php

namespace Ogae\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Ogae\Http\Requests;
use Ogae\Http\Controllers\Controller;

use Ogae\Post;
use Ogae\Comment;
use Ogae\User;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::get();

        return view('comments.index', compact('comments'));
    }

    public function download()
    {
      $this->downloadWordpress();
      // $this->downloadFacebook();
    }

    public function downloadWordpress()
    {
      $url = 'http://www.esccovers.com/comments/feed/?paged=';
      for ($i=1; $i < 20; $i++) {
        try {
          $feed = \RSS::feed($url.$i);
        }
        catch (\Vinelab\Rss\Exceptions\InvalidFeedContentException $e) {
          continue;
        }

        foreach ($feed->articles() as $item) {
          $user = User::firstOrNew(['wordpress_name' => $item->creator]);

          if (!$user->name) $user->name = $item->creator;
          if (!$user->email) $user->email = str_slug($item->creator, '.').'.'.md5($item->guid).'@ogae.kitbs.com';
          $user->save();

          $comment = Comment::with('post')->firstOrNew(['remote_id' => $item->guid, 'remote_source' => 'W']);
          $comment->body = $item->description;
          $comment->posted_at = \Carbon\Carbon::createFromFormat(\DateTime::RSS, $item->pubDate);

          if ($user && !$comment->user) {
            $comment->user()->associate($user);
          }

          if (!$comment->post) {
            $postGuid = strstr($comment->remote_id, '#', true);
              $post = Post::where('remote_id', $postGuid)->where('remote_source', 'W')->first();
              if ($post) {
                $comment->post()->associate($post);
              }
          }

          $comment->save();
        }
      }

      // return redirect()->route('admin.comments.index');

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
     * @param  int  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
