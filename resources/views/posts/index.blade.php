@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">Posts</div>
          <table class="table">
            <thead>
              <tr>
                <th class="col-md-4">Title</th>
                <th class="col-md-1">Site</th>
                <th class="col-md-3">Song</th>
                <th class="col-md-2">Performer</th>
                <th class="col-md-2">Country</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($posts as $post)
                <tr>
                  <td><a href="{{ route('admin.posts.edit', $post) }}"><em>{{ str_limit($post->title ?: $post->body ?: $post->remote_id, 80) }}</em></a></td>
                  <td>{{ $post->remote_source }}</td>
                  @if($post->song)
                    <td><a href="{{ route('admin.songs.edit', $post->song) }}"><em>{{ $post->song->name }}</em></a></td>
                    <td>{{ $post->song->performer }}</td>
                    <td>{{ $post->song->country }}</td>
                  @else
                    <td colspan="2"></td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
