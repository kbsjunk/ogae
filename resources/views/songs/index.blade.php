@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">Songs</div>
          <table class="table">
            <thead>
              <tr>
                <th rowspan="2" class="col-md-3">Song</th>
                <th rowspan="2" class="col-md-3">Performer</th>
                <th rowspan="2" class="col-md-3">Country</th>
                <th rowspan="2" class="text-center col-md-1">Semifinal</th>
                <th colspan="2" class="text-center">Points</th>
              </tr>
              <tr>
                <th class="text-right col-md-1">Semifinal</th>
                <th class="text-right col-md-1">Final</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($songs as $song)
              <tr>
                <td><a href="{{ route('admin.songs.edit', $song) }}"><em>{{ $song->name }}</em></a></td>
                <td>{{ $song->performer }}</td>
                <td>{{ $song->country }}</td>
                <td class="text-center">{{ $song->semifinal }}</td>
                <td class="text-right">{{ $song->semi_points }}</td>
                <td class="text-right">{{ $song->final_points }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
