<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\AuthorModel;
use App\Models\PublisherModel;
use App\Models\ShelfModel;
use App\Models\BorrowingModel;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks      = BookModel::count();
        $totalCategories = CategoryModel::count();
        $totalAuthors    = AuthorModel::count();
        $totalPublishers = PublisherModel::count();
        $totalShelves    = ShelfModel::count();
        $totalBorrowings = BorrowingModel::count();

        return view('pages.admin.dashboard', compact(
            'totalBooks',
            'totalCategories',
            'totalAuthors',
            'totalPublishers',
            'totalShelves',
            'totalBorrowings'
        ));
    }
}