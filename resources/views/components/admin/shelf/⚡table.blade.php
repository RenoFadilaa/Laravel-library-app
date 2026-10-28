<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ShelfModel;

new class extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $query = ShelfModel::latest();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('shelf_name', 'like', '%' . $this->search . '%')
                  ->orWhere('shelf_position', 'like', '%' . $this->search . '%');
            });
        }

        return [
            'shelfs' => $query->paginate(3)
        ];
    }
};
?>

<div>
    <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="font-bold text-lg text-base-content flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-primary"></i> Shelves List
            </h2>
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-base-content/50">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" wire:model.live="search" placeholder="Search shelves..." 
                    class="input input-bordered w-full pl-9 pr-4 py-1.5 rounded-xl text-xs focus:border-primary" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-base-content/70 border-b border-base-300">
                        <th class="w-16">No</th>
                        <th>Shelf Name</th>
                        <th>Position / Location</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-base-300">
                    @forelse($shelfs as $shelf)
                        <tr class="cursor-pointer hover:bg-base-200/50 transition-colors"
                            onclick="document.getElementById('shelfModal{{ $shelf->shelf_id }}').showModal()">
                            <th class="text-base-content/60 font-medium">{{ ($shelfs->currentPage() - 1) * $shelfs->perPage() + $loop->iteration }}</th>
                            <td class="font-semibold text-base-content">{{ $shelf->shelf_name }}</td>
                            <td class="text-base-content/85">{{ $shelf->shelf_position }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-base-content/50">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                No shelf data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Edit & Delete Modals (Moved outside table for valid HTML parsing) -->
        @foreach($shelfs as $shelf)
            <dialog id="shelfModal{{ $shelf->shelf_id }}" class="modal" wire:ignore.self>
                <div class="modal-box bg-base-100 border border-base-300 max-w-md rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-base-content">
                            Update Shelf
                        </h3>
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                        </form>
                    </div>
                    <div class="divider my-2"></div>
                    <form id="updateForm{{ $shelf->shelf_id }}"
                        action="{{ route('admin.shelf.update', $shelf->shelf_id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4 py-2">
                            <div class="form-control">
                                <label class="label pb-1">
                                    <span class="label-text font-medium text-base-content/80">Shelf Name</span>
                                </label>
                                <input type="text" name="shelf_name" value="{{ $shelf->shelf_name }}"
                                    class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            </div>

                            <div class="form-control">
                                <label class="label pb-1">
                                    <span class="label-text font-medium text-base-content/80">Position / Location</span>
                                </label>
                                <input type="text" name="shelf_position" value="{{ $shelf->shelf_position }}"
                                    class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            </div>
                        </div>
                    </form>
                    <div class="divider my-4"></div>
                    <div class="flex justify-between items-center">
                        <form action="{{ route('admin.shelf.destroy', $shelf->shelf_id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this shelf?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-error btn-outline rounded-xl btn-sm font-semibold">
                                <i class="fa-solid fa-trash-can mr-1"></i> Delete
                            </button>
                        </form>

                        <div class="flex gap-2">
                            <form method="dialog">
                                <button class="btn btn-ghost btn-sm rounded-xl">Cancel</button>
                            </form>
                            <button type="submit" form="updateForm{{ $shelf->shelf_id }}"
                                class="btn btn-primary text-white btn-sm rounded-xl px-4">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </dialog>
        @endforeach

        <div class="mt-6">
            {{ $shelfs->links() }}
        </div>
    </div>
</div>
