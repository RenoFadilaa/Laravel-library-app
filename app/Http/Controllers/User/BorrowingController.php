<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowingRequest;
use App\Models\BorrowingModel;
use App\Models\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $borrowings = BorrowingModel::getUserData($userId);
        
        // Fetch books with stock > 0 for borrowing select options
        $books = BookModel::where('book_stock', '>', 0)->orderBy('book_name')->get();
        
        return view('pages.user.borrowings', compact('borrowings', 'books'));
    }

    public function store(BorrowingRequest $request)
    {
        try {
            BorrowingModel::storeBorrowing(Auth::id(), $request->validated());
            return redirect()
                ->route('borrowings.index')
                ->with('success', 'Book borrowing request submitted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('borrowings.index')
                ->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $borrowing_id)
    {
        $request->validate([
            'borrowing_notes' => 'nullable|string',
        ]);

        $borrowing = BorrowingModel::where('borrowing_id', $borrowing_id)
            ->where('borrowing_user_id', Auth::id())
            ->first();

        if (!$borrowing) {
            return redirect()
                ->route('borrowings.index')
                ->with('error', 'Borrowing record not found.');
        }

        if ($borrowing->borrowing_isreturned) {
            return redirect()
                ->route('borrowings.index')
                ->with('error', 'Cannot update a borrowing that is already returned.');
        }

        $operation = $borrowing->update([
            'borrowing_notes' => $request->borrowing_notes,
        ]);

        if ($operation) {
            return redirect()
                ->route('borrowings.index')
                ->with('success', 'Successfully updated borrowing notes.');
        }

        return redirect()
            ->route('borrowings.index')
            ->with('error', 'Failed to update borrowing notes.');
    }

    public function destroy($borrowing_id)
    {
        $borrowing = BorrowingModel::where('borrowing_id', $borrowing_id)
            ->where('borrowing_user_id', Auth::id())
            ->first();

        if (!$borrowing) {
            return redirect()
                ->route('borrowings.index')
                ->with('error', 'Borrowing record not found.');
        }

        if ($borrowing->borrowing_isreturned) {
            return redirect()
                ->route('borrowings.index')
                ->with('error', 'Cannot cancel a borrowing that is already returned.');
        }

        $operation = BorrowingModel::destroyBorrowing($borrowing_id);

        if ($operation) {
            return redirect()
                ->route('borrowings.index')
                ->with('success', 'Successfully cancelled/deleted borrowing request.');
        }

        return redirect()
            ->route('borrowings.index')
            ->with('error', 'Failed to cancel borrowing request.');
    }
}
