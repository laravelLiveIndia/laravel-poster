<?php

namespace Laravellive\Poster\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravellive\Poster\Http\Requests\PosterRequest;
use Laravellive\Poster\Poster;

class PosterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('poster::welcome');
    }

    public function show()
    {
        $posts = Poster::latest()->paginate(20);
        return view('poster::show', compact('posts'));
    }

    public function send(PosterRequest $request)
    {
        Poster::storeAndNotify($request);
        return redirect(route('poster.index'))->with('message', 'Posting done');
    }
}
