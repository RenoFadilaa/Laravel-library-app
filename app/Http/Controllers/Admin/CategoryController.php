<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function index()
    {
        return view('pages.admin.category');
    }

    public function store(CategoryRequest $request)
    {
        $operation = CategoryModel::storeData($request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.category')
                ->with('success', 'Successfully created category.');
        }

        return redirect()
            ->route('admin.category')
            ->with('error', 'Failed to create category.');
    }

    public function update(CategoryRequest $request, $category_id)
    {
        $operation = CategoryModel::updateData($category_id, $request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.category')
                ->with('success', 'Successfully updated category.');
        }

        return redirect()
            ->route('admin.category')
            ->with('error', 'Failed to update category.');
    }

    public function destroy($category_id)
    {
        $operation = CategoryModel::destroyData($category_id);

        if ($operation) {
            return redirect()
                ->route('admin.category')
                ->with('success', 'Successfully deleted category.');
        }

        return redirect()
            ->route('admin.category')
            ->with('error', 'Failed to delete category.');
    }
}
