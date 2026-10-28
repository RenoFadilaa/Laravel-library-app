<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\AuthorModel;

class AuthorController extends Controller
{


    public function search(Request $request) {
    $author_name = $request->query('author_name');
    $authors = AuthorModel::getAuthorsByName($author_name);

    return response()->json($authors);
    }

    public function index()
    {
        return view('pages.admin.author');
    }

    public function store(AuthorRequest $request)
    {
        $operation = AuthorModel::create([
            'author_name' => $request->author_name,
            'author_description' => $request->author_description,
        ]);

        if ($operation) {
            return redirect()
                ->route('admin.author')
                ->with('success', 'Successfully create author data.');
        }

        return redirect()
            ->route('admin.author')
            ->with('error', 'Failed to create author data.');
    }

    public function update(AuthorRequest $request, $author_id)
    {
        $author = AuthorModel::find($author_id);

        if (!$author) {
            return redirect()
                ->route('admin.author')
                ->with('error', 'Author not found.');
        }

        $operation = $author->update([
            'author_name' => $request->author_name,
            'author_description' => $request->author_description,
        ]);

        if ($operation) {
            return redirect()
                ->route('admin.author')
                ->with('success', 'Successfully update author data.');
        }

        return redirect()
            ->route('admin.author')
            ->with('error', 'Failed to update author data.');
    }

    public function destroy($author_id)
    {
        $author = AuthorModel::find($author_id);

        if (!$author) {
            return redirect()
                ->route('admin.author')
                ->with('error', 'Author not found.');
        }

        $operation = $author->delete();

        if ($operation) {
            return redirect()
                ->route('admin.author')
                ->with('success', 'Successfully delete author data.');
        }

        return redirect()
            ->route('admin.author')
            ->with('error', 'Failed to delete author data.');
    }
}