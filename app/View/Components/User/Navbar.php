<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public function __construct()
    {
    }

    public function render(): View|Closure|string
    {
        $loggedIn = Auth::check();
        $user = Auth::user();

        $menus = [
            [
                'label' => 'Home',
                'href' => route('home'),
            ],
            [
                'label' => 'Books',
                'href' => route('books.index'),
            ],
        ];

        if ($loggedIn) {
            $menus[] = [
                'label' => 'My Borrowings',
                'href' => route('borrowings.index'),
            ];

            if ($user->isadmin) {
                $menus[] = [
                    'label' => 'Admin Panel',
                    'href' => route('admin.dashboard'),
                ];
            }
        }

        return view('components.user.navbar', compact(
            'loggedIn',
            'menus',
            'user'
        ));
    }
}