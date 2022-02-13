<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingByUserResource;
use Illuminate\Http\Request;

class RatingsByUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $ratings = $request->user()->ratings;

        return RatingByUserResource::collection($ratings);
    }
}