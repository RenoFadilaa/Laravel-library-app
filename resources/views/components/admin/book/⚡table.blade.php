<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BookModel;
use App\Models\AuthorModel;
use App\Models\CategoryModel;
use App\Models\PublisherModel;
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
        $query = BookModel::with(['category', 'publisher', 'shelf', 'author'])->latest();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('book_name', 'like', '%' . $this->search . '%')
                  ->orWhere('book_isbn', 'like', '%' . $this->search . '%')
                  ->orWhereHas('author', function($sq) {
                      $sq->where('author_name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('category', function($sq) {
                      $sq->where('category_name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('publisher', function($sq) {
                      $sq->where('publisher_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        return [
            'books' => $query->paginate(3),
            'authors' => AuthorModel::all(),
            'categories' => CategoryModel::all(),
            'publishers' => PublisherModel::all(),
            'shelfs' => ShelfModel::all(),
        ];
    }
};
?>

<div>
    <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="font-bold text-lg text-base-content flex items-center gap-2">
                <i class="fa-solid fa-book-bookmark text-primary"></i> Books List
            </h2>
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-base-content/50">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" wire:model.live="search" placeholder="Search books, authors, etc..." 
                    class="input input-bordered w-full pl-9 pr-4 py-1.5 rounded-xl text-xs focus:border-primary" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-base-content/70 border-b border-base-300">
                        <th class="w-12">No</th>
                        <th>Detail Buku</th>
                        <th>Relasi</th>
                        <th>Stok</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-base-300">
                    @forelse($books as $book)
                        <tr class="cursor-pointer hover:bg-base-200/50 transition-colors"
                            onclick="document.getElementById('bookModal{{ $book->book_id }}').showModal()">
                            <th class="text-base-content/60 font-medium align-middle">{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</th>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 h-16 rounded overflow-hidden shadow-sm bg-base-200">
                                            <img src="{{ $book->book_img }}" alt="{{ $book->book_name }}" class="object-cover w-full h-full" onerror="this.src='https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=120&auto=format&fit=crop'">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-base-content text-sm">{{ $book->book_name }}</div>
                                        <div class="text-xs text-base-content/60">ISBN: {{ $book->book_isbn }}</div>
                                        <div class="text-xs text-base-content/75 mt-1 max-w-xs truncate">{{ $book->book_description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="space-y-1.5 text-xs py-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 text-center text-primary"><i class="fa-solid fa-user"></i></span>
                                        <span class="w-16 font-bold text-base-content/50 text-[10px] uppercase tracking-wider">Author</span>
                                        <span class="text-base-content font-semibold">{{ $book->author->author_name ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 text-center text-primary"><i class="fa-solid fa-tags"></i></span>
                                        <span class="w-16 font-bold text-base-content/50 text-[10px] uppercase tracking-wider">Kategori</span>
                                        <span class="text-base-content font-semibold">{{ $book->category->category_name ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 text-center text-primary"><i class="fa-solid fa-building"></i></span>
                                        <span class="w-16 font-bold text-base-content/50 text-[10px] uppercase tracking-wider">Penerbit</span>
                                        <span class="text-base-content font-semibold">{{ $book->publisher->publisher_name ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 text-center text-primary"><i class="fa-solid fa-layer-group"></i></span>
                                        <span class="w-16 font-bold text-base-content/50 text-[10px] uppercase tracking-wider">Rak</span>
                                        <span class="text-base-content font-semibold">{{ $book->shelf->shelf_name ?? '-' }} <span class="text-base-content/50 font-normal">({{ $book->shelf->shelf_position ?? '-' }})</span></span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="font-bold {{ $book->book_stock > 0 ? 'text-base-content' : 'text-error' }}">
                                    {{ $book->book_stock }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-base-content/50">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                No book data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Edit & Delete Modals (Moved outside table for valid HTML parsing) -->
        @foreach($books as $book)
            <dialog id="bookModal{{ $book->book_id }}" class="modal" wire:ignore.self>
                <div class="modal-box bg-base-100 border border-base-300 max-w-lg rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl text-base-content">
                            Update Book
                        </h3>
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                        </form>
                    </div>
                    <div class="divider my-2"></div>
                    <form id="updateForm{{ $book->book_id }}"
                        action="{{ route('admin.book.update', $book->book_id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 py-2">
                            <div class="form-control md:col-span-2">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Judul Buku</span></label>
                                <input type="text" name="book_name" value="{{ $book->book_name }}"
                                    class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            </div>

                            <div class="form-control">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">ISBN</span></label>
                                <input type="text" name="book_isbn" value="{{ $book->book_isbn }}"
                                    class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            </div>

                            <div class="form-control">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Stok</span></label>
                                <input type="number" name="book_stock" value="{{ $book->book_stock }}"
                                    class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required min="0">
                            </div>

                            <div class="form-control">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Author</span></label>
                                <select name="book_author_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->author_id }}" {{ $book->book_author_id == $author->author_id ? 'selected' : '' }}>
                                            {{ $author->author_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Category</span></label>
                                <select name="book_category_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" {{ $book->book_category_id == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Publisher</span></label>
                                <select name="book_publisher_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                                    @foreach($publishers as $publisher)
                                        <option value="{{ $publisher->publisher_id }}" {{ $book->book_publisher_id == $publisher->publisher_id ? 'selected' : '' }}>
                                            {{ $publisher->publisher_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Shelf</span></label>
                                <select name="book_shelf_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                                    @foreach($shelfs as $shelf)
                                        <option value="{{ $shelf->shelf_id }}" {{ $book->book_shelf_id == $shelf->shelf_id ? 'selected' : '' }}>
                                            {{ $shelf->shelf_name }} ({{ $shelf->shelf_position }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control md:col-span-2">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Cover Image URL / String</span></label>
                                <input type="text" name="book_img" value="{{ $book->book_img }}"
                                    class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            </div>

                            <div class="form-control md:col-span-2">
                                <label class="label pb-0.5"><span class="label-text font-medium text-base-content/80">Deskripsi Buku</span></label>
                                <textarea name="book_description" rows="3"
                                    class="textarea textarea-bordered w-full rounded-xl focus:border-primary text-sm" required>{{ $book->book_description }}</textarea>
                            </div>
                        </div>
                    </form>
                    <div class="divider my-4"></div>
                    <div class="flex justify-between items-center">
                        <form action="{{ route('admin.book.destroy', $book->book_id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
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
                            <button type="submit" form="updateForm{{ $book->book_id }}"
                                class="btn btn-primary text-white btn-sm rounded-xl px-4">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </dialog>
        @endforeach

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
</div>
