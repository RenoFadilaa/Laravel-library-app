<x-admin.layout>

    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-base-content">
            Dashboard Overview
        </h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Books Card -->
        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-base-content/60 uppercase tracking-wider">Books</p>
                <h2 class="text-5xl font-black mt-2 text-base-content">
                    {{ $totalBooks }}
                </h2>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-primary/20 text-primary flex items-center justify-center text-3xl shadow-inner">
                <i class="fa-solid fa-book"></i>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-base-content/60 uppercase tracking-wider">Categories</p>
                <h2 class="text-5xl font-black mt-2 text-base-content">
                    {{ $totalCategories }}
                </h2>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-primary/15 text-primary flex items-center justify-center text-3xl shadow-inner">
                <i class="fa-solid fa-tags"></i>
            </div>
        </div>

        <!-- Authors Card -->
        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-base-content/60 uppercase tracking-wider">Authors</p>
                <h2 class="text-5xl font-black mt-2 text-base-content">
                    {{ $totalAuthors }}
                </h2>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-secondary/30 text-secondary-content flex items-center justify-center text-3xl shadow-inner">
                <i class="fa-solid fa-user-pen"></i>
            </div>
        </div>

        <!-- Publishers Card -->
        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-base-content/60 uppercase tracking-wider">Publishers</p>
                <h2 class="text-5xl font-black mt-2 text-base-content">
                    {{ $totalPublishers }}
                </h2>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-accent/40 text-accent-content flex items-center justify-center text-3xl shadow-inner">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>

        <!-- Shelves Card -->
        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-base-content/60 uppercase tracking-wider">Shelves</p>
                <h2 class="text-5xl font-black mt-2 text-base-content">
                    {{ $totalShelves }}
                </h2>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-base-300 text-base-content flex items-center justify-center text-3xl shadow-inner">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>

        <!-- Borrowings Card -->
        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card hover:scale-[1.02] transition-all duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-base-content/60 uppercase tracking-wider">Borrowings</p>
                <h2 class="text-5xl font-black mt-2 text-base-content">
                    {{ $totalBorrowings }}
                </h2>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-accent/30 text-accent-content flex items-center justify-center text-3xl shadow-inner">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>

    </div>

</x-admin.layout>