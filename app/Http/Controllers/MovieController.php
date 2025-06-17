<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MovieController extends Controller
{
    public function index()
    {
        $query = Movie::latest();
        if (request('q')) {
            $query->where('title', 'like', '%' . request('q') . '%');
        }
        $movies = $query->paginate(6)->withQueryString();
        return view('homepage', compact('movies'));
    }

    public function detail_movie($id, $slug)
    {
        $movie = Movie::find($id);
        return view('movie_detail', compact('movie'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('movie_form', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'actors' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Buat slug dari title
        $slug = Str::slug($request->title);

        // Handle upload gambar jika ada
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        // Simpan data movie ke database
        Movie::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'synopsis' => $validated['synopsis'],
            'category_id' => $validated['category_id'],
            'year' => $validated['year'],
            'actors' => $validated['actors'],
            'cover_image' => $coverPath,
        ]);

        return redirect('/movie')->with('success', 'Movie Saved Successfully.');
    }

    public function data_movie()
    {
        $movies = Movie::latest()->paginate(10);
        return view('admin.datamovie', compact('movies'));
    }

    public function edit($id)
    {
        $categories = Category::all();
        $movie = Movie::findOrFail($id);
        return view('admin.editmovie', compact('categories', 'movie'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'actors' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Buat slug dari title
        $slug = Str::slug($request->title);

        $data = Movie::findOrFail($id);
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $data->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'synopsis' => $validated['synopsis'],
                'category_id' => $validated['category_id'],
                'year' => $validated['year'],
                'actors' => $validated['actors'],
                'cover_image' => $coverPath,
            ]);
        } else {
            $data->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'synopsis' => $validated['synopsis'],
                'category_id' => $validated['category_id'],
                'year' => $validated['year'],
                'actors' => $validated['actors'],
            ]);
        }
        return redirect('/movie')->with('success', 'Movie updated successfully.');
    }

    public function destroy($id)
    {
        if (Gate::allows('delete-movie')) {
            $data = Movie::findOrFail($id);
            $data->delete();
            return redirect('/movie')->with('success', 'Movie deleted successfully.');
        } else {
            abort(403);
        }
    }
}
