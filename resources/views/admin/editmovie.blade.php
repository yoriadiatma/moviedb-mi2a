@extends('layouts.template')

@section('title', 'Form input movie')

@section('content')

    <h1>Form Edit Movie</h1>
    <a href="{{ route('dataMovie') }}" class="btn btn-primary mb-2">Data Movie</a>
    {{-- Tampilkan alert error jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada kesalahan pada input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/movie-update/{{ $movie->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Title --}}
        <div class="mb-3 row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-6">
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title', $movie->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Synopsis --}}
        <div class="mb-3 row">
            <label for="synopsis" class="col-sm-2 col-form-label">Synopsis</label>
            <div class="col-sm-6">
                <textarea class="form-control @error('synopsis') is-invalid @enderror" 
                          name="synopsis" id="synopsis" rows="5">{{ old('synopsis', $movie->synopsis) }}</textarea>
                @error('synopsis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Category --}}
        <div class="mb-3 row">
            <label for="category_id" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-6">
                <select name="category_id" id="category_id" 
                        class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('category_id', $movie->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Year --}}
        <div class="mb-3 row">
            <label for="year" class="col-sm-2 col-form-label">Year</label>
            <div class="col-sm-6">
                <input type="number" name="year" id="year" 
                       class="form-control @error('year') is-invalid @enderror" 
                       value="{{ old('year', $movie->year) }}">
                @error('year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Actors --}}
        <div class="mb-3 row">
            <label for="actors" class="col-sm-2 col-form-label">Actors</label>
            <div class="col-sm-6">
                <input type="text" name="actors" id="actors" 
                       class="form-control @error('actors') is-invalid @enderror" 
                       value="{{ old('actors', $movie->actors) }}">
                @error('actors')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Cover Image --}}
        <div class="mb-3 row">
            <label for="cover_image" class="col-sm-2 col-form-label">Cover Image</label>
            <div class="col-sm-6">
                <input type="file" name="cover_image" id="cover_image" 
                       class="form-control @error('cover_image') is-invalid @enderror">
                @error('cover_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @if ($movie->cover_image)
        <div class="mb-3 row">
            <label for="old_image" class="col-sm-2 col-form-label">Old Cover Image</label>
            <div class="col-sm-6">
                <img class="img-thumbnail" width="100px" src="{{ asset('storage/'.$movie->cover_image) }}" alt="">
            </div>
        </div>
        @endif

        {{-- Submit --}}
        <div class="mb-3 row">
            <div class="col-sm-6 offset-sm-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
@endsection
