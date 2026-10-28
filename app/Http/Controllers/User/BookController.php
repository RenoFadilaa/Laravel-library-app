<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BookModel;

class BookController extends Controller
{
    public function index()
    {
        // Eager load relationships and paginate for students
        $books = BookModel::with(['category', 'publisher', 'shelf', 'author'])->latest()->paginate(5);
        return view('pages.user.books', compact('books'));
    }
}
