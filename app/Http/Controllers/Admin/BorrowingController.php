<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowingModel;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        return view('pages.admin.borrowing');
    }

    public function update(Request $request, $borrowing_id)
    {
        $request->validate([
            'borrowing_isreturned' => 'required|boolean',
            'borrowing_notes' => 'nullable|string',
            'borrowing_fine' => 'nullable|integer|min:0',
        ]);

        $data = [
            'borrowing_isreturned' => (bool) $request->borrowing_isreturned,
            'borrowing_notes' => $request->borrowing_notes,
            'borrowing_fine' => $request->borrowing_fine !== null ? (int) $request->borrowing_fine : null,
        ];

        $operation = BorrowingModel::updateBorrowing($borrowing_id, $data);

        if ($operation) {
            return redirect()
                ->route('admin.borrowing')
                ->with('success', 'Successfully updated borrowing record.');
        }

        return redirect()
            ->route('admin.borrowing')
            ->with('error', 'Failed to update borrowing record.');
    }

    public function destroy($borrowing_id)
    {
        $operation = BorrowingModel::destroyBorrowing($borrowing_id);

        if ($operation) {
            return redirect()
                ->route('admin.borrowing')
                ->with('success', 'Successfully deleted borrowing record.');
        }

        return redirect()
            ->route('admin.borrowing')
            ->with('error', 'Failed to delete borrowing record.');
    }

    public function returnDetail($detail_id)
    {
        $operation = BorrowingModel::returnDetail($detail_id);

        if ($operation) {
            return redirect()
                ->route('admin.borrowing')
                ->with('success', 'Book has been marked as returned.');
        }

        return redirect()
            ->route('admin.borrowing')
            ->with('error', 'Failed to mark book as returned. It may already be returned.');
    }

    public function undoReturnDetail($detail_id)
    {
        $operation = BorrowingModel::undoReturnDetail($detail_id);

        if ($operation) {
            return redirect()
                ->route('admin.borrowing')
                ->with('success', 'Book return has been undone successfully.');
        }

        return redirect()
            ->route('admin.borrowing')
            ->with('error', 'Failed to undo book return.');
    }

    public function returnAll($borrowing_id)
    {
        $operation = BorrowingModel::returnAll($borrowing_id);

        if ($operation) {
            return redirect()
                ->route('admin.borrowing')
                ->with('success', 'All books have been marked as returned.');
        }

        return redirect()
            ->route('admin.borrowing')
            ->with('error', 'Failed to mark all books as returned.');
    }
}
