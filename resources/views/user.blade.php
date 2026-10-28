<x-user.layout>
    <x-slot:title>Home</x-slot:title>

    <x-slot:hero>
        <div class="hero min-h-[85vh] relative overflow-hidden"
            style="background-image: url({{ asset('nature_library_hero.png') }}); background-size: cover; background-position: center;">
            <div class="hero-overlay bg-gradient-to-tr from-neutral/90 via-primary/45 to-secondary/30 backdrop-blur-[1px]"></div>

            <div class="hero-content text-center text-white relative z-10">
                <div class="max-w-2xl bg-black/35 backdrop-blur-md p-8 md:p-12 rounded-3xl border border-white/10 shadow-2xl">
                    <span class="px-4 py-1.5 bg-primary/20 text-accent font-medium text-xs tracking-wider uppercase rounded-full border border-primary/30 inline-block mb-4">
                        <i class="fa-solid fa-leaf mr-1.5 animate-pulse text-accent"></i> Sanctuary of Knowledge
                    </span>
                    <h1 class="mb-5 text-3xl font-bold tracking-tight md:text-5xl lg:text-6xl drop-shadow-md">
                        Welcome to <span class="text-accent">Library App</span>
                    </h1>

                    <p class="mb-8 text-sm md:text-lg text-white/90 font-light max-w-lg mx-auto leading-relaxed">
                        Immerse yourself in a serene environment of learning. Discover, borrow, and read books surrounded by natural tranquility.
                    </p>

                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('books.index') }}" class="btn btn-primary px-8 rounded-xl shadow-lg shadow-primary/25 hover:scale-[1.02] transition duration-200">
                            <i class="fa-solid fa-book-open mr-2"></i> Browse Books
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline border-white text-white hover:bg-white hover:text-neutral px-8 rounded-xl hover:scale-[1.02] transition duration-200">
                                Join Now
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
            
            <!-- Sunlight glow effect bottom decoration -->
            <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-base-200 to-transparent"></div>
        </div>
    </x-slot:hero>

    <section class="py-20 px-6 bg-gradient-to-b from-base-200 to-base-100">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-primary font-semibold text-sm uppercase tracking-wider block mb-2">Curated Collection</span>
                    <h2 class="text-4xl font-bold tracking-tight text-base-content">
                        Popular Books
                    </h2>
                </div>
                <div class="w-16 h-1 bg-secondary rounded-full mt-4 md:mt-0"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">

                <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden nature-card">
                    <figure class="h-80 overflow-hidden relative group">
                        <img src="https://i.pinimg.com/vwebp/1200x/39/d9/d6/39d9d620d911c59cddd87302a2810bc3.webp"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-secondary/90 text-white text-xs px-2.5 py-1 rounded-lg font-medium shadow-md">
                            Best Seller
                        </div>
                    </figure>

                    <div class="card-body p-5">
                        <h2 class="card-title text-base font-bold line-clamp-1">
                            Atomic Habits
                        </h2>
                        <p class="text-xs text-base-content/70">James Clear</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden nature-card">
                    <figure class="h-80 overflow-hidden relative group">
                        <img src="https://i.pinimg.com/736x/c5/65/de/c565defa611e68c4690ab4e72b3836fb.jpg"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </figure>

                    <div class="card-body p-5">
                        <h2 class="card-title text-base font-bold line-clamp-1">
                            Rich Dad Poor Dad
                        </h2>
                        <p class="text-xs text-base-content/70">Robert Kiyosaki</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden nature-card">
                    <figure class="h-80 overflow-hidden relative group">
                        <img src="https://i.pinimg.com/736x/17/80/ea/1780ea463e7d187d4caaffe5295827dd.jpg"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </figure>

                    <div class="card-body p-5">
                        <h2 class="card-title text-base font-bold line-clamp-1">
                            Deep Work
                        </h2>
                        <p class="text-xs text-base-content/70">Cal Newport</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden nature-card">
                    <figure class="h-80 overflow-hidden relative group">
                        <img src="https://i.pinimg.com/736x/9a/f8/70/9af870cb16eaf030b6ab15b2f3e8da54.jpg"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </figure>

                    <div class="card-body p-5">
                        <h2 class="card-title text-base font-bold line-clamp-1">
                            Clean Code
                        </h2>
                        <p class="text-xs text-base-content/70">Robert C. Martin</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl border border-base-300 overflow-hidden nature-card">
                    <figure class="h-80 overflow-hidden relative group">
                        <img src="https://i.pinimg.com/1200x/05/15/cd/0515cd3cf93ee61e8713ff40a5e71daa.jpg"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </figure>

                    <div class="card-body p-5">
                        <h2 class="card-title text-base font-bold line-clamp-1">
                            Zero to One
                        </h2>
                        <p class="text-xs text-base-content/70">Peter Thiel</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-20 bg-base-100 px-6">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-primary font-semibold text-sm uppercase tracking-wider block mb-2">Explore Genres</span>
                    <h2 class="text-4xl font-bold tracking-tight text-base-content">
                        Categories
                    </h2>
                </div>
                <div class="w-16 h-1 bg-secondary rounded-full mt-4 md:mt-0"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

                <div class="card bg-primary/10 hover:bg-primary/15 border border-primary/20 text-base-content shadow-md transition-all hover:scale-[1.03] duration-300">
                    <div class="card-body items-center text-center py-8">
                        <div class="w-16 h-16 rounded-2xl bg-primary text-primary-content flex items-center justify-center text-3xl mb-4 shadow-lg shadow-primary/20">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <h2 class="font-bold text-lg">
                            Novel
                        </h2>
                    </div>
                </div>

                <div class="card bg-secondary/15 hover:bg-secondary/20 border border-secondary/25 text-base-content shadow-md transition-all hover:scale-[1.03] duration-300">
                    <div class="card-body items-center text-center py-8">
                        <div class="w-16 h-16 rounded-2xl bg-secondary text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-secondary/20">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <h2 class="font-bold text-lg">
                            Programming
                        </h2>
                    </div>
                </div>

                <div class="card bg-accent/25 hover:bg-accent/35 border border-accent/40 text-base-content shadow-md transition-all hover:scale-[1.03] duration-300">
                    <div class="card-body items-center text-center py-8">
                        <div class="w-16 h-16 rounded-2xl bg-neutral text-neutral-content flex items-center justify-center text-3xl mb-4 shadow-lg shadow-neutral/20">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h2 class="font-bold text-lg">
                            Business
                        </h2>
                    </div>
                </div>

                <div class="card bg-primary/10 hover:bg-primary/15 border border-primary/20 text-base-content shadow-md transition-all hover:scale-[1.03] duration-300">
                    <div class="card-body items-center text-center py-8">
                        <div class="w-16 h-16 rounded-2xl bg-primary text-primary-content flex items-center justify-center text-3xl mb-4 shadow-lg shadow-primary/20">
                            <i class="fa-solid fa-brain"></i>
                        </div>
                        <h2 class="font-bold text-lg">
                            Self Improvement
                        </h2>
                    </div>
                </div>

                <div class="card bg-secondary/15 hover:bg-secondary/20 border border-secondary/25 text-base-content shadow-md transition-all hover:scale-[1.03] duration-300">
                    <div class="card-body items-center text-center py-8">
                        <div class="w-16 h-16 rounded-2xl bg-secondary text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-secondary/20">
                            <i class="fa-solid fa-flask"></i>
                        </div>
                        <h2 class="font-bold text-lg">
                            Science
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot:scripts>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const navButton = document.getElementById('navButton');
                const navMenu = document.getElementById('navMenu');

                if (navButton && navMenu) {
                    navButton.addEventListener('click', () => {
                        navMenu.classList.toggle('hidden');
                        navMenu.classList.toggle('flex');
                    });
                }
            });
        </script>
    </x-slot:scripts>
</x-user.layout>