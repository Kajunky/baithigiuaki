<?php

namespace App\Http\Controllers;

use App\Models\Authors;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Authors::all();
        return view('authors.index', compact('authors'));
    }

    public function show(Authors $author)
    {
        return view('authors.show', compact('author'));
    }
}
