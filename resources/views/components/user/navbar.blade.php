<nav class="bg-base-100/80 backdrop-blur-md border-b border-base-300 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-8xl mx-auto px-8 h-20 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-base-content hover:text-primary transition flex items-center gap-2">
            <i class="fa-solid fa-leaf text-primary"></i>
            <span>Library App</span>
        </a>
        <ul class="flex items-center gap-8">
            @foreach($menus as $menu)
                <li>
                    <a href="{{ $menu['href'] }}" class="font-medium text-base-content/85 hover:text-primary transition">{{ $menu['label'] }}</a>
                </li>
            @endforeach
            @if($loggedIn && isset($user))
                <li class="dropdown dropdown-end ml-2">
                    <div tabindex="0" role="button" class="btn btn-ghost hover:bg-base-200 rounded-xl flex items-center gap-3 p-1">
                        <span class="text-base-content/80 font-medium hidden md:inline">{{ $user->firstname }} {{ $user->lastname }}</span>
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->firstname }}" class="w-10 h-10 rounded-full object-cover shadow-inner border border-base-300">
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold uppercase shadow-inner">
                                {{ mb_substr($user->firstname, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-2xl z-[50] w-52 p-2 shadow-xl border border-base-300 mt-2">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="py-3 rounded-xl hover:bg-base-200 flex items-center gap-2">
                                <i class="fa-solid fa-gear text-primary"></i> Settings
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left py-3 px-4 rounded-xl text-error hover:bg-error/10 flex items-center gap-2">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li class="flex gap-3">
                    <a href="{{ route('login') }}" class="btn btn-outline border-primary text-primary hover:bg-secondary hover:border-secondary btn-sm rounded-xl">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-xl shadow-md hover:shadow-lg transition duration-200">Register</a>
                </li>
            @endif
        </ul>
    </div>
</nav>