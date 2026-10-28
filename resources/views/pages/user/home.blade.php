<x-user.layout>
    <x-slot:title>Home Dashboard</x-slot:title>

    <x-slot:hero>
        <div class="hero min-h-[50vh] relative overflow-hidden"
            style="background-image: url({{ asset('nature_library_hero.png') }}); background-size: cover; background-position: center;">
            <div class="hero-overlay bg-gradient-to-tr from-neutral/90 via-primary/45 to-secondary/30 backdrop-blur-[1px]"></div>
            
            <div class="hero-content text-center text-white relative z-10 py-12">
                <div class="max-w-2xl px-6 py-8 bg-black/35 backdrop-blur-md rounded-3xl border border-white/10 shadow-2xl">
                    <span class="px-4 py-1 bg-primary/20 text-accent font-medium text-xs tracking-wider uppercase rounded-full border border-primary/30 inline-block mb-4">
                        <i class="fa-solid fa-leaf mr-1.5 animate-pulse text-accent"></i> Library Portal
                    </span>
                    <h1 class="mb-4 text-3xl md:text-5xl font-extrabold text-white leading-tight">
                        Discover Your Next Sanctuary
                    </h1>
                    <p class="mb-6 text-sm text-white/90 leading-relaxed font-light">
                        Access thousands of novels, guides, and academic papers. Borrow and manage your selection surrounded by natural tranquility.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('books.index') }}" class="btn btn-primary px-6 rounded-xl font-medium shadow-md shadow-primary/25">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i> Browse Books
                        </a>
                        <a href="{{ route('borrowings.index') }}" class="btn btn-outline border-white text-white hover:bg-white hover:text-neutral px-6 rounded-xl font-medium">
                            <i class="fa-solid fa-receipt mr-2"></i> My Borrowings
                        </a>
                    </div>
                </div>
            </div>
            <!-- Sunlight glow effect bottom decoration -->
            <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-base-200 to-transparent"></div>
        </div>
    </x-slot:hero>

    @if(session('success'))
        <div class="alert alert-success mb-8 rounded-xl shadow-sm max-w-7xl mx-auto flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-8 px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            
            <div class="bg-base-100 p-6 rounded-2xl shadow-md border border-base-300 flex items-center gap-5 nature-card">
                <div class="w-12 h-12 rounded-xl bg-primary/20 text-primary flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-base-content/60">Available Books</h3>
                    <p class="text-xl font-bold text-base-content mt-0.5">Explore Catalog</p>
                </div>
            </div>
            
            <div class="bg-base-100 p-6 rounded-2xl shadow-md border border-base-300 flex items-center gap-5 nature-card">
                <div class="w-12 h-12 rounded-xl bg-success/20 text-success flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-base-content/60">Borrowings</h3>
                    <p class="text-xl font-bold text-base-content mt-0.5">Manage Requests</p>
                </div>
            </div>

            <div class="bg-base-100 p-6 rounded-2xl shadow-md border border-base-300 flex items-center gap-5 nature-card">
                <div class="w-12 h-12 rounded-xl bg-secondary/30 text-secondary-content flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-base-content/60">Profile Role</h3>
                    <p class="text-xl font-bold text-base-content mt-0.5">{{ auth()->user()->isadmin ? 'Administrator' : 'Student' }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-base-100 p-8 rounded-2xl shadow-md border border-base-300 nature-card">
                <h2 class="text-xl font-bold text-base-content mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-leaf text-primary"></i> Library Sanctuary Rules
                </h2>
                <ul class="space-y-4 text-base-content/85 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-primary mt-1"></i>
                        <span>Students can request to borrow books that are currently in stock.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-primary mt-1"></i>
                        <span>All borrowed books must be returned in good condition.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-primary mt-1"></i>
                        <span>Fines may apply for late returns or damaged books (assessed by administrators).</span>
                    </li>
                </ul>
            </div>

            <div class="bg-gradient-to-br from-primary to-primary-focus p-8 rounded-2xl shadow-lg text-primary-content flex flex-col justify-between border border-primary/20 relative overflow-hidden">
                <!-- Background botanical decor leaf icon -->
                <div class="absolute -right-8 -bottom-8 text-primary-content/10 text-9xl pointer-events-none">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold mb-3">Need Assistance?</h2>
                    <p class="text-primary-content/90 text-sm leading-relaxed font-light">
                        If you experience any issues borrowing books, accessing your records, or changing passwords, please contact library staff at the administrator counter.
                    </p>
                </div>
                <div class="mt-6 flex items-center gap-3 text-sm text-primary-content/80 relative z-10 font-medium">
                    <i class="fa-solid fa-circle-question"></i>
                    <span>Admin desk open Monday - Friday, 08:00 - 16:00.</span>
                </div>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            // Add custom scripts here if needed
        </script>
    </x-slot:scripts>
</x-user.layout>
