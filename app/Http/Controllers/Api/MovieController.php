<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieIndexResource;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index($sort = null)
    {
        if ($sort) {
            return MovieIndexResource::collection(Movie::with('user')->orderBy($sort)->get());
        } else {
            return MovieIndexResource::collection(Movie::with('user')->get());
        }

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $movie = $request->user()->movies()->create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        return $movie;

    }

    public function like($id, Request $request)
    {
        $movie = Movie::findOrFail($id);

        $numberOfLikes = $movie->likes;
        $numberOfLikes++;
        $movie->likes = $numberOfLikes;
        $movie->save();

        return $movie;
    }

    public function hate($id, Request $request)
    {
        $movie = Movie::findOrFail($id);

        $numberOfHates = $movie->hates;
        $numberOfHates++;
        $movie->hates = $numberOfHates;
        $movie->save();

        return $movie;
    }
}