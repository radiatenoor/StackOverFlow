<?php

namespace App\Http\Controllers\User;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tags = Tag::orderBy('name','ASC')->get();
        return view('front.dashboard.dashboard')
            ->withTags($tags);
    }
}
