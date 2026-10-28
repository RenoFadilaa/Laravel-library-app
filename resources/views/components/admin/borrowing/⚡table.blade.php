<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BorrowingModel;

new class extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBorrowingId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showDetails($borrowingId)
    {
        $this->selectedBorrowingId = $borrowingId;
        // Dispatch browser event to show the detail modal
        $this->dispatch('open-detail-modal');
    }

    public function closeDetails()
    {
        $this->selectedBorrowingId = null;
    }

    public function getSelectedBorrowingProperty()
    {
        if (!$this->selectedBorrowingId) return null;
        return BorrowingModel::with(['user', 'details.book'])->find($this->selectedBorrowingId);
    }

    public function with(): array
    {
        $query = BorrowingModel::with(['user', 'details.book'])->latest();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('borrowing_notes', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($sq) {
                      $sq->where('firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('lastname', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        return [
            'borrowings' => $query->paginate(3)
        ];
    }
};
?>

<div>
    <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="font-bold text-lg text-base-content flex items-center gap-2">
                <i class="fa-solid fa-receipt text-primary"></i> All Student Borrowings
            </h2>
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-base-content/50">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" wire:model.live="search" placeholder="Search student or notes..." 
                    class="input input-bordered w-full pl-9 pr-4 py-1.5 rounded-xl text-xs focus:border-primary" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-base-content/70 border-b border-base-300">
                        <th class="w-12">No</th>
                        <th>Student Name</th>
                        <th>Borrowed Books</th>
                        <th>Status</th>
                        <th>Fine</th>
                        <th>Notes</th>
                        <th class="w-32">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-base-300">
                    @forelse($borrowings as $borrowing)
                        <tr class="hover:bg-base-200/50 transition-colors">
                            <th class="text-base-content/60 font-medium align-middle">
                                {{ ($borrowings->currentPage() - 1) * $borrowings->perPage() + $loop->iteration }}
                            </th>
                            <td class="align-middle">
                                <div class="font-semibold text-base-content">
                                    {{ $borrowing->user->firstname }} {{ $borrowing->user->lastname }}
                                </div>
                                <div class="text-xs text-base-content/60">@ {{ $borrowing->user->username }}</div>
                                <div class="text-xs text-base-content/60">{{ $borrowing->user->email }}</div>
                            </td>
                            <td class="align-middle">
                                <div class="flex flex-col gap-1.5 my-1">
                                    @foreach($borrowing->details as $detail)
                                        <div class="text-xs text-base-content flex items-center gap-1.5">
                                            @if($detail->detail_isreturned)
                                                <span class="badge badge-sm bg-success/20 text-success border-success/30 gap-0.5 px-1.5">
                                                    <i class="fa-solid fa-check text-[8px]"></i> Returned
                                                </span>
                                            @else
                                                <span class="badge badge-sm bg-warning/20 text-warning border-warning/30 gap-0.5 px-1.5">
                                                    <i class="fa-solid fa-clock text-[8px]"></i> Borrowed
                                                </span>
                                            @endif
                                            <span class="badge badge-neutral badge-sm font-semibold">Qty: {{ $detail->detail_quantity }}</span>
                                            <span>{{ $detail->book->book_name ?? 'Deleted Book' }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($borrowing->borrowing_isreturned)
                                    <span class="badge bg-success/20 text-success border-success/30 font-semibold px-2 py-2">
                                        <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> Returned
                                    </span>
                                @elseif($borrowing->details->where('detail_isreturned', true)->count() > 0)
                                    <span class="badge bg-info/20 text-info border-info/30 font-semibold px-2 py-2">
                                        <i class="fa-solid fa-circle-half-stroke mr-1 text-[10px]"></i> Partial
                                    </span>
                                @else
                                    <span class="badge bg-secondary/20 text-secondary-content border-secondary/30 font-semibold px-2 py-2">
                                        <i class="fa-solid fa-clock mr-1 text-[10px]"></i> Borrowed
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle font-medium text-base-content">
                                @if($borrowing->borrowing_fine)
                                    <span class="text-error font-bold">Rp{{ number_format($borrowing->borrowing_fine, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-base-content/40">-</span>
                                @endif
                            </td>
                            <td class="align-middle text-base-content/75 text-sm max-w-xs truncate">
                                {{ $borrowing->borrowing_notes ?? '-' }}
                            </td>
                            <td class="align-middle">
                                <div class="flex items-center gap-1.5">
                                    <button class="btn btn-sm btn-ghost btn-circle text-primary hover:bg-primary/10"
                                        wire:click="showDetails('{{ $borrowing->borrowing_id }}')" title="Detail Peminjaman">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline btn-primary rounded-xl"
                                        onclick="document.getElementById('editBorrowingModal{{ $borrowing->borrowing_id }}').showModal()">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.borrowing.destroy', $borrowing->borrowing_id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this borrowing record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error btn-outline btn-circle rounded-xl" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/50">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                No borrowing records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Edit Modals (Moved outside table for valid HTML parsing) -->
        @foreach($borrowings as $borrowing)
            <!-- Edit Modal -->
            <dialog id="editBorrowingModal{{ $borrowing->borrowing_id }}" class="modal" wire:ignore.self>
                <div class="modal-box bg-base-100 border border-base-300 max-w-md rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-base-content">
                            Manage Borrowing
                        </h3>
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                        </form>
                    </div>
                    <div class="divider my-2"></div>
                    <form id="updateBorrowingForm{{ $borrowing->borrowing_id }}"
                        action="{{ route('admin.borrowing.update', $borrowing->borrowing_id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4 py-2">
                            <div class="form-control">
                                <label class="label pb-1">
                                    <span class="label-text font-medium text-base-content/80">Status</span>
                                </label>
                                <select name="borrowing_isreturned" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                                    <option value="0" {{ !$borrowing->borrowing_isreturned ? 'selected' : '' }}>Still Borrowing (Not Returned)</option>
                                    <option value="1" {{ $borrowing->borrowing_isreturned ? 'selected' : '' }}>Returned</option>
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label pb-1">
                                    <span class="label-text font-medium text-base-content/80">Fine (Rupiah)</span>
                                </label>
                                <input type="number" name="borrowing_fine" value="{{ $borrowing->borrowing_fine }}"
                                    placeholder="e.g. 5000" class="input input-bordered w-full rounded-xl focus:border-primary text-sm" min="0">
                                <label class="label pt-0.5">
                                    <span class="label-text-alt text-base-content/50">Leave blank if there is no fine.</span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="label pb-1">
                                    <span class="label-text font-medium text-base-content/80">Notes / Remarks</span>
                                </label>
                                <textarea name="borrowing_notes" rows="3" placeholder="Add remarks..."
                                    class="textarea textarea-bordered w-full rounded-xl focus:border-primary text-sm">{{ $borrowing->borrowing_notes }}</textarea>
                            </div>
                        </div>
                    </form>
                    <div class="divider my-4"></div>
                    <div class="flex justify-end gap-2">
                        <form method="dialog">
                            <button class="btn btn-ghost btn-sm rounded-xl">Cancel</button>
                        </form>
                        <button type="submit" form="updateBorrowingForm{{ $borrowing->borrowing_id }}"
                            class="btn btn-primary text-white btn-sm rounded-xl px-4">
                            Save Changes
                        </button>
                    </div>
                </div>
        @endforeach

        <div class="mt-6">
            {{ $borrowings->links() }}
        </div>
    </div>

    <!-- Details Modal (Livewire-controlled) -->
    <div x-data="{ open: false }" 
         x-on:open-detail-modal.window="open = true"
         x-on:close-detail-modal.window="open = false"
         x-show="open" 
         class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none"
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-neutral-900/60 backdrop-blur-sm transition-opacity" x-on:click="open = false; $wire.closeDetails()"></div>

        <!-- Modal Box -->
        <div class="relative w-full max-w-2xl mx-auto my-6 z-10 px-4">
            <div class="bg-base-100 border border-base-300 rounded-3xl p-6 sm:p-8 shadow-2xl nature-card max-h-[90vh] overflow-y-auto">
                
                <!-- Modal Header -->
                <div class="flex justify-between items-center pb-4 border-b border-base-300">
                    <h3 class="font-extrabold text-2xl text-base-content flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-primary"></i> Detail Peminjaman
                    </h3>
                    <button class="btn btn-sm btn-circle btn-ghost" x-on:click="open = false; $wire.closeDetails()">✕</button>
                </div>

                <!-- Modal Body -->
                @if($this->selectedBorrowing)
                    <div class="py-6 space-y-6">
                        <!-- Student & Transaction Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student Card -->
                            <div class="bg-base-200/50 rounded-2xl p-4 border border-base-300">
                                <h4 class="font-bold text-xs uppercase tracking-wider text-base-content/50 mb-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-graduation-cap"></i> Student Profile
                                </h4>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary/20 text-primary-content rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg">
                                            {{ strtoupper(substr($this->selectedBorrowing->user->firstname, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-base-content text-base">
                                            {{ $this->selectedBorrowing->user->firstname }} {{ $this->selectedBorrowing->user->lastname }}
                                        </div>
                                        <div class="text-xs text-base-content/60">@ {{ $this->selectedBorrowing->user->username }}</div>
                                        <div class="text-xs text-base-content/60">{{ $this->selectedBorrowing->user->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction Details -->
                            <div class="bg-base-200/50 rounded-2xl p-4 border border-base-300 space-y-3 text-sm">
                                <h4 class="font-bold text-xs uppercase tracking-wider text-base-content/50 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> Transaction Stats
                                </h4>
                                <div class="flex justify-between items-center border-b border-base-300 pb-1.5">
                                    <span class="text-base-content/60">Status:</span>
                                    @if($this->selectedBorrowing->borrowing_isreturned)
                                        <span class="badge bg-success/20 text-success border-success/30 font-semibold px-2">Returned</span>
                                    @else
                                        <span class="badge bg-secondary/20 text-secondary-content border-secondary/30 font-semibold px-2">Borrowed</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center border-b border-base-300 pb-1.5">
                                    <span class="text-base-content/60">Fine Amount:</span>
                                    @if($this->selectedBorrowing->borrowing_fine)
                                        <span class="text-error font-bold">Rp{{ number_format($this->selectedBorrowing->borrowing_fine, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-base-content/40">No fine</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-base-content/60">Tanggal Pinjam:</span>
                                    <span class="font-medium text-base-content">{{ $this->selectedBorrowing->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Card -->
                        <div class="bg-base-200/30 rounded-2xl p-4 border border-base-300">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-base-content/50 mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-comment-dots"></i> Notes / Remarks
                            </h4>
                            <p class="text-sm text-base-content/80 whitespace-pre-line">
                                {{ $this->selectedBorrowing->borrowing_notes ?? 'No remarks provided for this borrowing record.' }}
                            </p>
                        </div>

                        <!-- Book list itemization -->
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-bold text-sm text-base-content flex items-center gap-1.5">
                                    <i class="fa-solid fa-book-open text-primary"></i> Itemized Borrowed Books
                                </h4>
                                @php
                                    $unreturnedCount = $this->selectedBorrowing->details->where('detail_isreturned', false)->count();
                                @endphp
                                @if($unreturnedCount > 0 && !$this->selectedBorrowing->borrowing_isreturned)
                                    <form action="{{ route('admin.borrowing.return-all', $this->selectedBorrowing->borrowing_id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to return ALL books in this borrowing?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success text-white rounded-xl gap-1">
                                            <i class="fa-solid fa-check-double text-xs"></i> Return All Books
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="border border-base-300 rounded-2xl overflow-hidden">
                                <table class="table w-full">
                                    <thead>
                                        <tr class="bg-base-200/50 text-base-content/75 border-b border-base-300">
                                            <th>Book Details</th>
                                            <th class="w-20 text-center">Qty</th>
                                            <th class="w-24 text-center">Status</th>
                                            <th class="w-28 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-base-300">
                                        @foreach($this->selectedBorrowing->details as $detail)
                                            <tr class="{{ $detail->detail_isreturned ? 'bg-success/5' : 'bg-base-100' }}">
                                                <td>
                                                    <div class="flex items-center gap-3">
                                                        <div class="avatar">
                                                            <div class="w-10 h-14 rounded overflow-hidden shadow-sm bg-base-200">
                                                                <img src="{{ $detail->book->book_img }}" alt="{{ $detail->book->book_name }}" class="object-cover w-full h-full" onerror="this.src='https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=120&auto=format&fit=crop'">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="font-bold text-base-content text-sm {{ $detail->detail_isreturned ? 'line-through opacity-60' : '' }}">{{ $detail->book->book_name ?? 'Deleted Book' }}</div>
                                                            <div class="text-xs text-base-content/60">ISBN: {{ $detail->book->book_isbn ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center font-bold text-base-content align-middle">
                                                    {{ $detail->detail_quantity }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if($detail->detail_isreturned)
                                                        <span class="badge badge-sm bg-success/20 text-success border-success/30 font-semibold gap-0.5">
                                                            <i class="fa-solid fa-check text-[8px]"></i> Returned
                                                        </span>
                                                    @else
                                                        <span class="badge badge-sm bg-warning/20 text-warning border-warning/30 font-semibold gap-0.5">
                                                            <i class="fa-solid fa-clock text-[8px]"></i> Borrowed
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if(!$detail->detail_isreturned)
                                                        <form action="{{ route('admin.borrowing.detail.return', $detail->detail_id) }}" method="POST"
                                                            onsubmit="return confirm('Confirm return for this book?')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-xs btn-success btn-outline rounded-lg gap-0.5" title="Mark as returned">
                                                                <i class="fa-solid fa-arrow-rotate-left text-[10px]"></i> Return
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.borrowing.detail.undo-return', $detail->detail_id) }}" method="POST"
                                                            onsubmit="return confirm('Undo return for this book? Stock will be re-deducted.')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-xs btn-warning btn-outline rounded-lg gap-0.5" title="Undo return">
                                                                <i class="fa-solid fa-rotate-left text-[10px]"></i> Undo
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Return progress indicator -->
                            @php
                                $totalDetails = $this->selectedBorrowing->details->count();
                                $returnedDetails = $this->selectedBorrowing->details->where('detail_isreturned', true)->count();
                                $progressPercent = $totalDetails > 0 ? round(($returnedDetails / $totalDetails) * 100) : 0;
                            @endphp
                            <div class="mt-3 px-1">
                                <div class="flex justify-between items-center text-xs text-base-content/60 mb-1">
                                    <span>Return Progress</span>
                                    <span class="font-semibold">{{ $returnedDetails }}/{{ $totalDetails }} books returned</span>
                                </div>
                                <progress class="progress {{ $progressPercent == 100 ? 'progress-success' : 'progress-primary' }} w-full h-2" value="{{ $progressPercent }}" max="100"></progress>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Modal Footer -->
                <div class="flex justify-end pt-4 border-t border-base-300">
                    <button class="btn btn-primary text-white rounded-xl px-6" x-on:click="open = false; $wire.closeDetails()">
                        Close Details
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
