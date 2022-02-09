<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieIndexResource;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        return MovieIndexResource::collection(Movie::all());
    }
}