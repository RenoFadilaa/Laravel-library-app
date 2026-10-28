<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PublisherModel;

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
        $query = PublisherModel::latest();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('publisher_name', 'like', '%' . $this->search . '%')
                  ->orWhere('publisher_description', 'like', '%' . $this->search . '%');
            });
        }

        return [
            'publishers' => $query->paginate(3)
        ];
    }
};
?>

<div>
    <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="font-bold text-lg text-base-content flex items-center gap-2">
                <i class="fa-solid fa-building text-primary"></i> Publishers List
            </h2>
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-base-content/50">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" wire:model.live="search" placeholder="Search publishers..." 
                    class="input input-bordered w-full pl-9 pr-4 py-1.5 rounded-xl text-xs focus:border-primary" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-base-content/70 border-b border-base-300">
                        <th class="w-16">No</th>
                        <th>Publisher Name</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-base-300">
                    @forelse($publishers as $publisher)
                        <tr class="cursor-pointer hover:bg-base-200/50 transition-colors"
                            onclick="document.getElementById('publisherModal{{ $publisher->publisher_id }}').showModal()">
                            <th class="text-base-content/60 font-medium">{{ ($publishers->currentPage() - 1) * $publishers->perPage() + $loop->iteration }}</th>
                            <td class="font-semibold text-base-content">{{ $publisher->publisher_name }}</td>
                            <td class="text-base-content/85">{{ $publisher->publisher_description ?? 'No description provided' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-base-content/50">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                No publisher data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Edit & Delete Modals (Moved outside table for valid HTML parsing) -->
        @foreach($publishers as $publisher)
            <dialog id="publisherModal{{ $publisher->publisher_id }}" class="modal" wire:ignore.self>
                <div class="modal-box bg-base-100 border border-base-300 max-w-md rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-base-content">
                            Update Publisher
                        </h3>
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                        </form>
                    </div>
                    <div class="divider my-2"></div>
                    <form id="updateForm{{ $publisher->publisher_id }}"
                        action="{{ route('admin.publisher.update', $publisher->publisher_id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4 py-2">
                            <div class="form-control">
                                <label class="label pb-1">
                                    <span class="label-text font-medium text-base-content/80">Publisher Name</span>
                                </label>
                                <input type="text" name="publisher_name" value="{{ $publisher->publisher_name }}"
                                    class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            </div>

                            <div class="form-control">
                                <label class="label pb-1">
                                    <span class="label-text font-medium text-base-content/80">Description</span>
                                </label>
                                <textarea name="publisher_description" rows="4"
                                    class="textarea textarea-bordered w-full rounded-xl focus:border-primary text-sm">{{ $publisher->publisher_description }}</textarea>
                            </div>
                        </div>
                    </form>
                    <div class="divider my-4"></div>
                    <div class="flex justify-between items-center">
                        <form action="{{ route('admin.publisher.destroy', $publisher->publisher_id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this publisher?')">
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
                            <button type="submit" form="updateForm{{ $publisher->publisher_id }}"
                                class="btn btn-primary text-white btn-sm rounded-xl px-4">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </dialog>
        @endforeach

        <div class="mt-6">
            {{ $publishers->links() }}
        </div>
    </div>
</div>
