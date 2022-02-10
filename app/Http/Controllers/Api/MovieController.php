<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieIndexResource;
use App\Models\Movie;

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
}