<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublisherRequest;
use App\Models\PublisherModel;

class PublisherController extends Controller
{
    public function index()
    {
        return view('pages.admin.publisher');
    }

    public function store(PublisherRequest $request)
    {
        $operation = PublisherModel::storeData($request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.publisher')
                ->with('success', 'Successfully created publisher.');
        }

        return redirect()
            ->route('admin.publisher')
            ->with('error', 'Failed to create publisher.');
    }

    public function update(PublisherRequest $request, $publisher_id)
    {
        $operation = PublisherModel::updateData($publisher_id, $request->validated());

        if ($operation) {
            return redirect()
                ->route('admin.publisher')
                ->with('success', 'Successfully updated publisher.');
        }

        return redirect()
            ->route('admin.publisher')
            ->with('error', 'Failed to update publisher.');
    }

    public function destroy($publisher_id)
    {
        $operation = PublisherModel::destroyData($publisher_id);

        if ($operation) {
            return redirect()
                ->route('admin.publisher')
                ->with('success', 'Successfully deleted publisher.');
        }

        return redirect()
            ->route('admin.publisher')
            ->with('error', 'Failed to delete publisher.');
    }
}
