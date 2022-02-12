<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function show($id)
    {
        return Rating::findOrFail($id);
    }

    public function store($movieId, Request $request)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:-1|max:1',
        ]);

        $rating = Rating::make($data);
        $rating->user_id = $request->user()->id;
        $rating->movie_id = $movieId;
        $rating->save();

        return $rating;

    }
}