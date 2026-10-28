<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckAuthMiddleware;
use App\Http\Middleware\CheckIsAdminRoleMiddleware;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\ShelfController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', fn() => redirect()->route(auth()->user()->isadmin ? 'admin.dashboard' : 'home'))->name('dashboard');

Route::middleware(CheckAuthMiddleware::class)->group(function () {
    // User Routes
    Route::controller(App\Http\Controllers\User\BookController::class)->group(function () {
        Route::get('/books', 'index')->name('books.index');
    });

    Route::controller(App\Http\Controllers\User\BorrowingController::class)->group(function () {
        Route::get('/borrowings', 'index')->name('borrowings.index');
        Route::post('/borrowings', 'store')->name('borrowings.store');
        Route::patch('/borrowings/{borrowing_id}', 'update')->name('borrowings.update');
        Route::delete('/borrowings/{borrowing_id}', 'destroy')->name('borrowings.destroy');
    });

    // Profile Settings Routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(CheckIsAdminRoleMiddleware::class)->prefix('/admin')->name('admin.')->group(function () {

        // Admin Dashboard
        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
        });

        // Author
        Route::controller(AuthorController::class)->group(function () {
            Route::get('/author', 'index')->name('author');
            Route::post('/author', 'store')->name('author.store');
            Route::patch('/author/{author_id}', 'update')->name('author.update');
            Route::delete('/author/{author_id}', 'destroy')->name('author.destroy');
        });

        // Publisher
        Route::controller(PublisherController::class)->group(function () {
            Route::get('/publisher', 'index')->name('publisher');
            Route::post('/publisher', 'store')->name('publisher.store');
            Route::patch('/publisher/{publisher_id}', 'update')->name('publisher.update');
            Route::delete('/publisher/{publisher_id}', 'destroy')->name('publisher.destroy');
        });

        // Shelf
        Route::controller(ShelfController::class)->group(function () {
            Route::get('/shelf', 'index')->name('shelf');
            Route::post('/shelf', 'store')->name('shelf.store');
            Route::patch('/shelf/{shelf_id}', 'update')->name('shelf.update');
            Route::delete('/shelf/{shelf_id}', 'destroy')->name('shelf.destroy');
        });

        // Category
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/category', 'index')->name('category');
            Route::post('/category', 'store')->name('category.store');
            Route::patch('/category/{category_id}', 'update')->name('category.update');
            Route::delete('/category/{category_id}', 'destroy')->name('category.destroy');
        });

        // Book
        Route::controller(BookController::class)->group(function () {
            Route::get('/book', 'index')->name('book');
            Route::post('/book', 'store')->name('book.store');
            Route::patch('/book/{book_id}', 'update')->name('book.update');
            Route::delete('/book/{book_id}', 'destroy')->name('book.destroy');
        });

        // Borrowing
        Route::controller(AdminBorrowingController::class)->group(function () {
            Route::get('/borrowing', 'index')->name('borrowing');
            Route::patch('/borrowing/{borrowing_id}', 'update')->name('borrowing.update');
            Route::delete('/borrowing/{borrowing_id}', 'destroy')->name('borrowing.destroy');
            Route::patch('/borrowing/detail/{detail_id}/return', 'returnDetail')->name('borrowing.detail.return');
            Route::patch('/borrowing/detail/{detail_id}/undo-return', 'undoReturnDetail')->name('borrowing.detail.undo-return');
            Route::patch('/borrowing/{borrowing_id}/return-all', 'returnAll')->name('borrowing.return-all');
        });
    });
});

require __DIR__.'/auth.php';
