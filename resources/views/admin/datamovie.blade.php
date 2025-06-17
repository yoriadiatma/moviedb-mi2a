@extends('layouts.template')

@section('content')
    <h1>Data Movie</h1>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Title</th>
      <th scope="col">Category</th>
      <th scope="col">Year</th>
      <th scope="col">Actors</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($movies as $index => $movie)
    <tr>
        <th scope="row">{{ $index + 1 }}</th>
        <td>{{ $movie->title }}</td>
        <td>{{ $movie->category->category_name }}</td>
        <td>{{ $movie->year }}</td>
        <td>{{ $movie->actors }}</td>
        <td>
            <div class="d-flex gap-1">
            <a href="/movie/{{ $movie->id }}/{{ $movie->slug }}" class="btn btn-primary btn-sm">Detail</a>
            <a href="/movie-edit/{{ $movie->id }}" class="btn btn-warning btn-sm">Edit</a>
            @can('delete')
            <form action="/movie-delete/{{ $movie->id }}" method="post">
              @csrf
              <button onclick="return confirm('Are you sure to delete this movie?')" class="btn btn-danger btn-sm" type="submit">Delete</button>
            </form>
            @endcan
            </div>
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $movies->links() }}
@endsection