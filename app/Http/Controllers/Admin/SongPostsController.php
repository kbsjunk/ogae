<?php

namespace Ogae\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Ogae\Http\Requests;
use Ogae\Http\Controllers\Controller;

use Ogae\Song;
use Ogae\Post;
use Ogae\User;

class SongPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Song $song)
    {
      $posts = $song->posts()->get();

      return view('posts.index', compact('posts'));
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
     * @param  int  Song $song
     * @param  int  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song, Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Song $song
     * @param  int  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song, Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Song $song
     * @param  int  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Song $song
     * @param  int  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song, Post $post)
    {
        //
    }
}
