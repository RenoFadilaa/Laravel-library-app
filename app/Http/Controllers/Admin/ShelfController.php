<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShelfRequest;
use App\Models\ShelfModel;

class ShelfController extends Controller
{
    public function index()
    {
        return view('pages.admin.shelf');
    }

    public function store(ShelfRequest $request)
    {
        $operation = ShelfModel::storeData($request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.shelf')
                ->with('success', 'Successfully created shelf.');
        }

        return redirect()
            ->route('admin.shelf')
            ->with('error', 'Failed to create shelf.');
    }

    public function update(ShelfRequest $request, $shelf_id)
    {
        $operation = ShelfModel::updateData($shelf_id, $request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.shelf')
                ->with('success', 'Successfully updated shelf.');
        }

        return redirect()
            ->route('admin.shelf')
            ->with('error', 'Failed to update shelf.');
    }

    public function destroy($shelf_id)
    {
        $operation = ShelfModel::destroyData($shelf_id);

        if ($operation) {
            return redirect()
                ->route('admin.shelf')
                ->with('success', 'Successfully deleted shelf.');
        }

        return redirect()
            ->route('admin.shelf')
            ->with('error', 'Failed to delete shelf.');
    }
}
