<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieIndexResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieByUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        return MovieIndexResource::collection(Movie::with('user')->where('user_id', $id)->orderBy('created_at')->get());
    }
}