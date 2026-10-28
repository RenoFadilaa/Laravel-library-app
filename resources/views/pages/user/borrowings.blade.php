<x-user.layout>
    <x-slot:title>My Borrowing Transactions</x-slot:title>

    <x-slot:hero>
        <div class="bg-gradient-to-r from-neutral to-primary py-12 text-white border-b border-primary/20 shadow-md">
            <div class="max-w-7xl mx-auto px-6 md:px-8">
                <h1 class="text-3xl font-extrabold flex items-center gap-2 tracking-tight">
                    <i class="fa-solid fa-receipt text-accent"></i> My Borrowings
                </h1>
                <p class="text-white/80 text-sm mt-2 font-light">
                    Manage and request your library books borrowing logs.
                </p>
            </div>
        </div>
    </x-slot:hero>

    @if(session('success'))
        <div class="alert alert-success mb-6 rounded-xl shadow-sm max-w-7xl mx-auto flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-lg text-success-content"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-6 rounded-xl shadow-sm max-w-7xl mx-auto flex items-center gap-3">
            <i class="fa-solid fa-circle-xmark text-lg text-error-content"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Borrowing Request Form -->
            <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 h-fit nature-card">
                <h2 class="font-bold text-lg text-base-content mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-primary"></i> New Borrowing Request
                </h2>

                @if ($errors->any())
                    <div class="alert alert-error mb-4 rounded-xl text-xs py-3 flex items-start gap-1">
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('borrowings.store') }}" method="POST" id="borrowForm">
                    @csrf
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label pb-1.5">
                                <span class="label-text font-medium text-base-content/80">Select Books</span>
                            </label>
                            
                            <!-- Dynamic Book Rows Container -->
                            <div id="bookRows" class="space-y-3">
                                <div class="flex items-center gap-2 book-row" data-index="0">
                                    <select name="items[0][book_id]" class="select select-bordered w-full rounded-xl text-xs select-sm" required>
                                        <option value="" disabled selected>Select Book</option>
                                        @foreach($books as $book)
                                            <option value="{{ $book->book_id }}">
                                                {{ $book->book_name }} (Stock: {{ $book->book_stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="items[0][quantity]" value="1" min="1" placeholder="Qty"
                                        class="input input-bordered w-20 rounded-xl text-xs input-sm text-center" required>
                                    <button type="button" class="btn btn-sm btn-error btn-outline rounded-xl remove-row-btn disabled" disabled>
                                        ✕
                                    </button>
                                </div>
                            </div>

                            <button type="button" id="addRowBtn" class="btn btn-ghost btn-sm mt-3 rounded-xl border border-base-300 text-primary hover:bg-primary/10 w-full text-xs">
                                <i class="fa-solid fa-plus mr-1"></i> Add Another Book
                            </button>
                        </div>

                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text font-medium text-base-content/80">Borrowing Notes</span>
                            </label>
                            <textarea name="borrowing_notes" placeholder="Optional notes (e.g. For class project)" rows="3"
                                class="textarea textarea-bordered w-full rounded-xl text-sm">{{ old('borrowing_notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-full text-white rounded-xl py-3 shadow-md shadow-primary/20 hover:scale-[1.01] transition-transform">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>

            <!-- Borrowing Records Table -->
            <div class="lg:col-span-2 bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card">
                <h2 class="font-bold text-lg text-base-content mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-primary"></i> My Borrowing Records
                </h2>

                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="text-base-content/70 border-b border-base-300">
                                <th class="w-12">No</th>
                                <th>Borrowed Books</th>
                                <th>Status</th>
                                <th>Fine</th>
                                <th>Notes</th>
                                <th class="w-24">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-base-300">
                            @forelse($borrowings as $borrowing)
                                <tr class="hover:bg-base-200/50 transition-colors">
                                    <th class="text-base-content/60 font-medium align-middle">
                                        {{ ($borrowings->currentPage() - 1) * $borrowings->perPage() + $loop->iteration }}
                                    </th>
                                    <td class="align-middle">
                                        <div class="flex flex-col gap-1.5 my-1">
                                            @foreach($borrowing->details as $detail)
                                                <div class="text-xs text-base-content/85 flex items-center gap-1.5">
                                                    <span class="badge badge-neutral badge-sm font-semibold">Qty: {{ $detail->detail_quantity }}</span>
                                                    <span>{{ $detail->book->book_name ?? 'Deleted Book' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @if($borrowing->borrowing_isreturned)
                                            <span class="badge bg-success/20 text-success border-success/30 font-semibold px-2.5 py-1.5 text-xs">
                                                <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> Returned
                                            </span>
                                        @else
                                            <span class="badge bg-secondary/20 text-secondary-content border-secondary/30 font-semibold px-2.5 py-1.5 text-xs">
                                                <i class="fa-solid fa-clock mr-1 text-[10px]"></i> Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle font-semibold text-xs">
                                        @if($borrowing->borrowing_fine)
                                            <span class="text-error font-bold">Rp{{ number_format($borrowing->borrowing_fine, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-base-content/40">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-base-content/75 text-xs max-w-xs truncate">
                                        {{ $borrowing->borrowing_notes ?? '-' }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="flex items-center gap-2">
                                            @if(!$borrowing->borrowing_isreturned)
                                                <button class="btn btn-xs btn-outline btn-primary rounded-xl"
                                                    onclick="document.getElementById('editUserBorrowingModal{{ $borrowing->borrowing_id }}').showModal()">
                                                    Notes
                                                </button>

                                                <form action="{{ route('borrowings.destroy', $borrowing->borrowing_id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to cancel this borrowing request?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-error btn-outline rounded-xl" title="Cancel Request">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-base-content/50 text-xs italic">Completed</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-base-content/50 text-sm">
                                        <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                        You have no borrowing records
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Edit Notes Modals (Moved outside table for valid HTML parsing) -->
                @foreach($borrowings as $borrowing)
                    @if(!$borrowing->borrowing_isreturned)
                        <dialog id="editUserBorrowingModal{{ $borrowing->borrowing_id }}" class="modal">
                            <div class="modal-box bg-base-100 border border-base-300 max-w-md rounded-2xl p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-lg text-base-content">
                                        Update Request Notes
                                    </h3>
                                    <form method="dialog">
                                        <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                                    </form>
                                </div>
                                <div class="divider my-1"></div>
                                <form id="updateNotesForm{{ $borrowing->borrowing_id }}"
                                    action="{{ route('borrowings.update', $borrowing->borrowing_id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-control py-2">
                                        <label class="label pb-1">
                                            <span class="label-text font-medium text-base-content/80">Notes / Remarks</span>
                                        </label>
                                        <textarea name="borrowing_notes" rows="4" placeholder="Update notes here..."
                                            class="textarea textarea-bordered w-full rounded-xl text-sm" required>{{ $borrowing->borrowing_notes }}</textarea>
                                    </div>
                                </form>
                                <div class="divider my-4"></div>
                                <div class="flex justify-end gap-2">
                                    <form method="dialog">
                                        <button class="btn btn-ghost btn-sm rounded-xl">Cancel</button>
                                    </form>
                                    <button type="submit" form="updateNotesForm{{ $borrowing->borrowing_id }}"
                                        class="btn btn-primary text-white btn-sm rounded-xl px-4">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </dialog>
                    @endif
                @endforeach

                <div class="mt-6">
                    {{ $borrowings->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Dropdown Book Template for JS cloning -->
    <template id="bookRowTemplate">
        <div class="flex items-center gap-2 book-row">
            <select name="items[INDEX][book_id]" class="select select-bordered w-full rounded-xl text-xs select-sm" required>
                <option value="" disabled selected>Select Book</option>
                @foreach($books as $book)
                    <option value="{{ $book->book_id }}">
                        {{ $book->book_name }} (Stock: {{ $book->book_stock }})
                    </option>
                @endforeach
            </select>
            <input type="number" name="items[INDEX][quantity]" value="1" min="1" placeholder="Qty"
                class="input input-bordered w-20 rounded-xl text-xs input-sm text-center" required>
            <button type="button" class="btn btn-sm btn-error btn-outline rounded-xl remove-row-btn">
                ✕
            </button>
        </div>
    </template>

    <x-slot:scripts>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const bookRows = document.getElementById('bookRows');
                const addRowBtn = document.getElementById('addRowBtn');
                const bookRowTemplate = document.getElementById('bookRowTemplate').innerHTML;
                let indexCounter = 1;

                function updateRemoveButtons() {
                    const rows = bookRows.querySelectorAll('.book-row');
                    const firstRowRemoveBtn = rows[0].querySelector('.remove-row-btn');
                    
                    if (rows.length === 1) {
                        firstRowRemoveBtn.classList.add('disabled');
                        firstRowRemoveBtn.disabled = true;
                    } else {
                        rows.forEach(row => {
                            const btn = row.querySelector('.remove-row-btn');
                            btn.classList.remove('disabled');
                            btn.disabled = false;
                        });
                    }
                }

                addRowBtn.addEventListener('click', () => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = bookRowTemplate.replace(/INDEX/g, indexCounter);
                    const newRow = tempDiv.firstElementChild;
                    
                    bookRows.appendChild(newRow);
                    indexCounter++;
                    updateRemoveButtons();
                });

                bookRows.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-row-btn')) {
                        const row = e.target.closest('.book-row');
                        const rows = bookRows.querySelectorAll('.book-row');
                        if (rows.length > 1) {
                            row.remove();
                            updateRemoveButtons();
                        }
                    }
                });

                updateRemoveButtons();
            });
        </script>
    </x-slot:scripts>
</x-user.layout>
