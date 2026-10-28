<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\PublisherModel;
use App\Models\ShelfModel;
use App\Models\AuthorModel;

class BookController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::orderBy('category_name')->get();
        $publishers = PublisherModel::orderBy('publisher_name')->get();
        $shelfs = ShelfModel::orderBy('shelf_name')->get();
        $authors = AuthorModel::orderBy('author_name')->get();

        return view('pages.admin.book', compact('categories', 'publishers', 'shelfs', 'authors'));
    }

    public function store(BookRequest $request)
    {
        $operation = BookModel::storeData($request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.book')
                ->with('success', 'Successfully created book.');
        }

        return redirect()
            ->route('admin.book')
            ->with('error', 'Failed to create book.');
    }

    public function update(BookRequest $request, $book_id)
    {
        $operation = BookModel::updateData($book_id, $request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.book')
                ->with('success', 'Successfully updated book.');
        }

        return redirect()
            ->route('admin.book')
            ->with('error', 'Failed to update book.');
    }

    public function destroy($book_id)
    {
        $operation = BookModel::destroyData($book_id);

        if ($operation) {
            return redirect()
                ->route('admin.book')
                ->with('success', 'Successfully deleted book.');
        }

        return redirect()
            ->route('admin.book')
            ->with('error', 'Failed to delete book.');
    }
}
