<x-admin.layout>

    <x-slot:title>
        Book Management
    </x-slot:title>

    @if(session('success'))
        <div class="alert alert-success mb-6 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-6 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-xmark text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-base-content">
            Book Management
        </h1>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-2">
            <livewire:admin.book.table />
        </div>

        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card">
            <h2 class="font-bold text-lg text-base-content mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-plus text-primary"></i> Create Book
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

            <form action="{{ route('admin.book.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="form-control">
                        <input type="text" name="book_name" value="{{ old('book_name') }}" placeholder="Book Title"
                            class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <input type="text" name="book_isbn" value="{{ old('book_isbn') }}" placeholder="ISBN"
                                class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                        </div>
                        <div class="form-control">
                            <input type="number" name="book_stock" value="{{ old('book_stock') }}" placeholder="Stock"
                                class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required min="0">
                        </div>
                    </div>

                    <div class="form-control">
                        <select name="book_author_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            <option value="" disabled selected>Select Author</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->author_id }}" {{ old('book_author_id') == $author->author_id ? 'selected' : '' }}>
                                    {{ $author->author_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <select name="book_category_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ old('book_category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <select name="book_publisher_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            <option value="" disabled selected>Select Publisher</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->publisher_id }}" {{ old('book_publisher_id') == $publisher->publisher_id ? 'selected' : '' }}>
                                    {{ $publisher->publisher_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <select name="book_shelf_id" class="select select-bordered w-full rounded-xl focus:border-primary text-sm" required>
                            <option value="" disabled selected>Select Shelf</option>
                            @foreach($shelfs as $shelf)
                                <option value="{{ $shelf->shelf_id }}" {{ old('book_shelf_id') == $shelf->shelf_id ? 'selected' : '' }}>
                                    {{ $shelf->shelf_name }} ({{ $shelf->shelf_position }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <input type="text" name="book_img" value="{{ old('book_img', 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=120&auto=format&fit=crop') }}" placeholder="Cover Image URL / String"
                            class="input input-bordered w-full rounded-xl focus:border-primary text-sm" required>
                    </div>

                    <div class="form-control">
                        <textarea name="book_description" placeholder="Description" rows="3"
                            class="textarea textarea-bordered w-full rounded-xl focus:border-primary text-sm" required>{{ old('book_description') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full text-white rounded-xl py-3 shadow-md shadow-primary/20">
                        <i class="fa-solid fa-plus mr-1"></i> Create Book
                    </button>
                </div>
            </form>
        </div>

    </div>

</x-admin.layout>
