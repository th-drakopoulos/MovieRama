<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReverseRatingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $rating = Rating::findOrFail($id);

        $rating->rating = -1 * $rating->rating;

        $movie = Movie::findOrFail($rating->movie_id);
        if ($rating->rating > 0) {
            $movie->likes++;
            $movie->hates--;
        } else {
            $movie->hates++;
            $movie->likes--;
        }

        $movie->save();
        $rating->save();

        return new RatingResource($rating);
    }
}