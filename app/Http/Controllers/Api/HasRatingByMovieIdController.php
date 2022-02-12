<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class HasRatingByMovieIdController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($movieId, Request $request)
    {
        $rating = Rating::where('user_id', '=', $request->user()->id)->where('movie_id', '=', $movieId)->get();
        if ($rating->isEmpty()) {
            $success = false;
            $message = 'No rating found for this user';
        } else {
            $success = true;
            $message = 'Rating found for this user';
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return response()->json($response);
    }
}