<x-user.layout>
    <x-slot:title>Books Catalog</x-slot:title>

    <x-slot:hero>
        <div class="bg-gradient-to-r from-neutral to-primary py-12 text-white border-b border-primary/20 shadow-md">
            <div class="max-w-7xl mx-auto px-6 md:px-8 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-extrabold flex items-center gap-2 tracking-tight">
                        <i class="fa-solid fa-leaf text-accent"></i> Books Catalog
                    </h1>
                    <p class="text-white/80 text-sm mt-2 font-light">
                        Browse all available books in our library collection.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex gap-2">
                    <span class="badge bg-white/10 text-white border-white/20 px-3 py-2 rounded-lg text-xs">
                        <i class="fa-solid fa-seedling mr-1"></i> Sage Theme Active
                    </span>
                </div>
            </div>
        </div>
    </x-slot:hero>

    <div class="max-w-7xl mx-auto py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <h2 class="text-2xl font-bold text-base-content flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-primary"></i> Available Books
            </h2>
            <a href="{{ route('borrowings.index') }}" class="btn btn-primary btn-sm rounded-xl px-5 shadow-md shadow-primary/20">
                <i class="fa-solid fa-cart-plus mr-1"></i> Make Borrowing Request
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @forelse($books as $book)
                <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden flex flex-col justify-between nature-card">
                    <div>
                        <figure class="h-64 bg-base-200 relative overflow-hidden group">
                            <img src="{{ $book->book_img }}" alt="{{ $book->book_name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" onerror="this.src='https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=120&auto=format&fit=crop'">
                            <div class="absolute top-2 right-2">
                                <span class="badge {{ $book->book_stock > 0 ? 'bg-success text-success-content' : 'bg-error text-error-content' }} border-none font-semibold text-[10px] uppercase">
                                    {{ $book->book_stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </figure>

                        <div class="p-4">
                            <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-1 rounded-md uppercase tracking-wider">
                                {{ $book->category->category_name ?? 'General' }}
                            </span>
                            <h3 class="font-bold text-base-content text-sm mt-3 line-clamp-2 h-10" title="{{ $book->book_name }}">
                                {{ $book->book_name }}
                            </h3>
                            <p class="text-xs text-base-content/75 mt-1.5 flex items-center gap-1.5 font-medium">
                                <i class="fa-regular fa-user text-primary"></i> {{ $book->author->author_name ?? 'Unknown Author' }}
                            </p>
                            <p class="text-[11px] text-base-content/60 mt-1">ISBN: {{ $book->book_isbn }}</p>
                            <p class="text-xs text-base-content/85 mt-2 line-clamp-3 leading-relaxed" title="{{ $book->book_description }}">
                                {{ $book->book_description }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 border-t border-base-300 bg-base-200/50 flex justify-between items-center text-xs">
                        <span class="text-base-content/80">Stock: <strong class="text-base-content">{{ $book->book_stock }}</strong></span>
                        <span class="text-base-content/60 italic">{{ $book->publisher->publisher_name ?? '' }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-base-100 rounded-2xl border border-base-300">
                    <i class="fa-regular fa-folder-open text-5xl text-base-content/40 mb-3 block"></i>
                    <h3 class="font-bold text-base-content text-lg">No Books Found</h3>
                    <p class="text-base-content/60 text-sm mt-1">Check back later for new arrivals.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $books->links() }}
        </div>
    </div>

    <x-slot:scripts>
        <script></script>
    </x-slot:scripts>
</x-user.layout>
