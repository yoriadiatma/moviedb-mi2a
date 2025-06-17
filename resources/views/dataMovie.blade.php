@extends('layouts.template')

@section('content')
    <h1>Data Movie</h1>
    <a href="/create-movie" class="btn btn-success mb-4">Input Movie</a>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">No</th>
        <th scope="col">Title</th>
        <th scope="col">Category</th>
        <th scope="col">Year</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movies as $index => $movie)
        <tr>
            <th scope="row">{{ $movies->firstItem() + $index }}</th>
            <td>{{ $movie->title }}</td>
            <td>{{ $movie->category->category_name }}</td>
            <td>{{ $movie->year }}</td>
            <td>
                <a href="" class="btn btn-success btn-sm">Show</a>
                <a href="/editmovie/{{ $movie->id }}" class="btn btn-warning btn-sm">Edit</a>
                @can('delete')
                    <a href="/deletemovie/{{ $movie->id }}" class="btn btn-danger btn-sm">Delete</a>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
    {{ $movies->links() }}
@endsection