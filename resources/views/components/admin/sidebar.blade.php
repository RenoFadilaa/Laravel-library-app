<aside class="w-72 h-screen fixed top-0 left-0 shadow-2xl flex flex-col justify-between overflow-y-auto shrink-0 z-30"
       style="background: linear-gradient(180deg, #2D382E 0%, #253028 100%);">

    <div>
        <!-- Logo section with wood-grain bottom accent -->
        <div class="p-8 border-b border-white/8 relative">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary text-primary-content flex items-center justify-center shadow-lg shadow-primary/30">
                    <i class="fa-solid fa-leaf text-lg animate-leaf-float"></i>
                </div>
                <span class="text-2xl font-bold text-white/90">Library Admin</span>
            </div>
            <!-- Wood-grain accent line -->
            <div class="absolute bottom-0 left-6 right-6 h-[2px] rounded-full" style="background: linear-gradient(90deg, #A67C52 0%, #C4A882 50%, #A67C52 100%); opacity: 0.4;"></div>
        </div>

        <ul class="mt-6 space-y-1 px-3">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-5 py-3 rounded-xl text-white/70 hover:bg-white/8 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary/25 text-white border-l-[3px] border-primary font-semibold shadow-sm' : '' }}">
                    <i class="fa-solid fa-house mr-3 w-5 text-center text-sm"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.author') }}"
                    class="flex items-center px-5 py-3 rounded-xl text-white/70 hover:bg-white/8 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.author*') ? 'bg-primary/25 text-white border-l-[3px] border-primary font-semibold shadow-sm' : '' }}">
                    <i class="fa-solid fa-user mr-3 w-5 text-center text-sm"></i>
                    Author
                </a>
            </li>

            <li>
                <a href="{{ route('admin.publisher') }}"
                    class="flex items-center px-5 py-3 rounded-xl text-white/70 hover:bg-white/8 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.publisher*') ? 'bg-primary/25 text-white border-l-[3px] border-primary font-semibold shadow-sm' : '' }}">
                    <i class="fa-solid fa-building mr-3 w-5 text-center text-sm"></i>
                    Publisher
                </a>
            </li>

            <li>
                <a href="{{ route('admin.shelf') }}"
                    class="flex items-center px-5 py-3 rounded-xl text-white/70 hover:bg-white/8 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.shelf*') ? 'bg-primary/25 text-white border-l-[3px] border-primary font-semibold shadow-sm' : '' }}">
                    <i class="fa-solid fa-layer-group mr-3 w-5 text-center text-sm"></i>
                    Shelf
                </a>
            </li>

            <li>
                <a href="{{ route('admin.category') }}"
                    class="flex items-center px-5 py-3 rounded-xl text-white/70 hover:bg-white/8 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.category*') ? 'bg-primary/25 text-white border-l-[3px] border-primary font-semibold shadow-sm' : '' }}">
                    <i class="fa-solid fa-tags mr-3 w-5 text-center text-sm"></i>
                    Category
                </a>
            </li>

            <li>
                <a href="{{ route('admin.book') }}"
                    class="flex items-center px-5 py-3 rounded-xl text-white/70 hover:bg-white/8 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.book*') ? 'bg-primary/25 text-white border-l-[3px] border-primary font-semibold shadow-sm' : '' }}">
                    <i class="fa-solid fa-book mr-3 w-5 text-center text-sm"></i>
                    Book
                </a>
            </li>

            <li>
                <a href="{{ route('admin.borrowing') }}"
                    class="flex items-center px-5 py-3 rounded-xl text-white/70 hover:bg-white/8 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.borrowing*') ? 'bg-primary/25 text-white border-l-[3px] border-primary font-semibold shadow-sm' : '' }}">
                    <i class="fa-solid fa-receipt mr-3 w-5 text-center text-sm"></i>
                    Borrowings
                </a>
            </li>
        </ul>
    </div>

    <div class="p-4 border-t border-white/8 mb-4">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="flex items-center px-5 py-3 rounded-xl text-red-400/80 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200 font-medium">
            <i class="fa-solid fa-right-from-bracket mr-3 w-5 text-center text-sm"></i>
            Logout
        </a>
    </div>

</aside>