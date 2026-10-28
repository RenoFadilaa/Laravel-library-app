<?php

use App\Models\User;
use App\Models\AuthorModel;
use App\Models\PublisherModel;
use App\Models\ShelfModel;
use App\Models\CategoryModel;
use App\Models\BookModel;
use App\Models\BorrowingModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Helper function to create users
function createAdminUser() {
    return User::create([
        'firstname' => 'Admin',
        'lastname' => 'User',
        'username' => 'admin',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'isadmin' => true,
    ]);
}

function createStudentUser() {
    return User::create([
        'firstname' => 'Student',
        'lastname' => 'User',
        'username' => 'student',
        'email' => 'student@test.com',
        'password' => bcrypt('password'),
        'isadmin' => false,
    ]);
}

test('admin can manage publisher crud', function () {
    $admin = createAdminUser();

    // Create
    $response = $this->actingAs($admin)
        ->post(route('admin.publisher.store'), [
            'publisher_name' => 'Gramedia',
            'publisher_description' => 'National Publisher',
        ]);
    $response->assertRedirect(route('admin.publisher'));
    $this->assertDatabaseHas('publishers', ['publisher_name' => 'Gramedia']);

    $publisher = PublisherModel::first();

    // Update
    $response = $this->actingAs($admin)
        ->patch(route('admin.publisher.update', $publisher->publisher_id), [
            'publisher_name' => 'Gramedia Pustaka',
            'publisher_description' => 'Updated Publisher Description',
        ]);
    $response->assertRedirect(route('admin.publisher'));
    $this->assertDatabaseHas('publishers', ['publisher_name' => 'Gramedia Pustaka']);

    // Delete
    $response = $this->actingAs($admin)
        ->delete(route('admin.publisher.destroy', $publisher->publisher_id));
    $response->assertRedirect(route('admin.publisher'));
    $this->assertDatabaseMissing('publishers', ['publisher_id' => $publisher->publisher_id]);
});

test('admin can manage shelf crud', function () {
    $admin = createAdminUser();

    // Create
    $response = $this->actingAs($admin)
        ->post(route('admin.shelf.store'), [
            'shelf_name' => 'Rak A',
            'shelf_position' => 'Lantai 1',
        ]);
    $response->assertRedirect(route('admin.shelf'));
    $this->assertDatabaseHas('shelfs', ['shelf_name' => 'Rak A']);

    $shelf = ShelfModel::first();

    // Update
    $response = $this->actingAs($admin)
        ->patch(route('admin.shelf.update', $shelf->shelf_id), [
            'shelf_name' => 'Rak A1',
            'shelf_position' => 'Lantai 1 Pojok',
        ]);
    $response->assertRedirect(route('admin.shelf'));
    $this->assertDatabaseHas('shelfs', ['shelf_name' => 'Rak A1']);

    // Delete
    $response = $this->actingAs($admin)
        ->delete(route('admin.shelf.destroy', $shelf->shelf_id));
    $response->assertRedirect(route('admin.shelf'));
    $this->assertDatabaseMissing('shelfs', ['shelf_id' => $shelf->shelf_id]);
});

test('admin can manage category crud', function () {
    $admin = createAdminUser();

    // Create
    $response = $this->actingAs($admin)
        ->post(route('admin.category.store'), [
            'category_name' => 'Programming',
            'category_description' => 'Coding and Tech',
        ]);
    $response->assertRedirect(route('admin.category'));
    $this->assertDatabaseHas('categories', ['category_name' => 'Programming']);

    $category = CategoryModel::first();

    // Update
    $response = $this->actingAs($admin)
        ->patch(route('admin.category.update', $category->category_id), [
            'category_name' => 'Computer Science',
            'category_description' => 'Coding and Math',
        ]);
    $response->assertRedirect(route('admin.category'));
    $this->assertDatabaseHas('categories', ['category_name' => 'Computer Science']);

    // Delete
    $response = $this->actingAs($admin)
        ->delete(route('admin.category.destroy', $category->category_id));
    $response->assertRedirect(route('admin.category'));
    $this->assertDatabaseMissing('categories', ['category_id' => $category->category_id]);
});

test('admin can manage book crud', function () {
    $admin = createAdminUser();

    // Create supporting master data
    $author = AuthorModel::create(['author_name' => 'Robert C. Martin']);
    $publisher = PublisherModel::create(['publisher_name' => 'Prentice Hall']);
    $shelf = ShelfModel::create(['shelf_name' => 'Rak A', 'shelf_position' => 'Lantai 1']);
    $category = CategoryModel::create(['category_name' => 'Software Engineering']);

    // Create Book
    $response = $this->actingAs($admin)
        ->post(route('admin.book.store'), [
            'book_author_id' => $author->author_id,
            'book_publisher_id' => $publisher->publisher_id,
            'book_shelf_id' => $shelf->shelf_id,
            'book_category_id' => $category->category_id,
            'book_name' => 'Clean Code',
            'book_isbn' => '978-0132350884',
            'book_stock' => 10,
            'book_description' => 'A Handbook of Agile Software Craftsmanship',
            'book_img' => 'http://example.com/cleancode.jpg',
        ]);
    $response->assertRedirect(route('admin.book'));
    $this->assertDatabaseHas('books', ['book_name' => 'Clean Code']);

    $book = BookModel::first();

    // Update Book
    $response = $this->actingAs($admin)
        ->patch(route('admin.book.update', $book->book_id), [
            'book_author_id' => $author->author_id,
            'book_publisher_id' => $publisher->publisher_id,
            'book_shelf_id' => $shelf->shelf_id,
            'book_category_id' => $category->category_id,
            'book_name' => 'Clean Code (Updated)',
            'book_isbn' => '978-0132350884',
            'book_stock' => 8,
            'book_description' => 'A Handbook of Agile Software Craftsmanship - Updated',
            'book_img' => 'http://example.com/cleancode.jpg',
        ]);
    $response->assertRedirect(route('admin.book'));
    $this->assertDatabaseHas('books', ['book_name' => 'Clean Code (Updated)', 'book_stock' => 8]);

    // Delete Book
    $response = $this->actingAs($admin)
        ->delete(route('admin.book.destroy', $book->book_id));
    $response->assertRedirect(route('admin.book'));
    $this->assertDatabaseMissing('books', ['book_id' => $book->book_id]);
});

test('student can borrow books and manage borrowing transactions', function () {
    $student = createStudentUser();

    // Create supporting master data
    $author = AuthorModel::create(['author_name' => 'Robert C. Martin']);
    $publisher = PublisherModel::create(['publisher_name' => 'Prentice Hall']);
    $shelf = ShelfModel::create(['shelf_name' => 'Rak A', 'shelf_position' => 'Lantai 1']);
    $category = CategoryModel::create(['category_name' => 'Software Engineering']);

    $book = BookModel::create([
        'book_author_id' => $author->author_id,
        'book_publisher_id' => $publisher->publisher_id,
        'book_shelf_id' => $shelf->shelf_id,
        'book_category_id' => $category->category_id,
        'book_name' => 'Clean Code',
        'book_isbn' => '978-0132350884',
        'book_stock' => 5,
        'book_description' => 'A Handbook of Agile Software Craftsmanship',
        'book_img' => 'http://example.com/cleancode.jpg',
    ]);

    // Request borrowing
    $response = $this->actingAs($student)
        ->post(route('borrowings.store'), [
            'borrowing_notes' => 'Need it for study',
            'items' => [
                [
                    'book_id' => $book->book_id,
                    'quantity' => 2,
                ]
            ]
        ]);

    $response->assertRedirect(route('borrowings.index'));
    $this->assertDatabaseHas('borrowings', [
        'borrowing_user_id' => $student->id,
        'borrowing_notes' => 'Need it for study',
    ]);

    // Verify stock is decremented
    $book->refresh();
    expect($book->book_stock)->toBe(3);

    $borrowing = BorrowingModel::first();

    // Update borrowing notes
    $response = $this->actingAs($student)
        ->patch(route('borrowings.update', $borrowing->borrowing_id), [
            'borrowing_notes' => 'Need it for study - updated note',
        ]);
    $response->assertRedirect(route('borrowings.index'));
    $this->assertDatabaseHas('borrowings', [
        'borrowing_id' => $borrowing->borrowing_id,
        'borrowing_notes' => 'Need it for study - updated note',
    ]);

    // Cancel borrowing
    $response = $this->actingAs($student)
        ->delete(route('borrowings.destroy', $borrowing->borrowing_id));
    $response->assertRedirect(route('borrowings.index'));
    $this->assertDatabaseMissing('borrowings', ['borrowing_id' => $borrowing->borrowing_id]);

    // Verify stock is restored
    $book->refresh();
    expect($book->book_stock)->toBe(5);
});

test('admin can manage all borrowing requests', function () {
    $student = createStudentUser();
    $admin = createAdminUser();

    // Create supporting master data
    $author = AuthorModel::create(['author_name' => 'Robert C. Martin']);
    $publisher = PublisherModel::create(['publisher_name' => 'Prentice Hall']);
    $shelf = ShelfModel::create(['shelf_name' => 'Rak A', 'shelf_position' => 'Lantai 1']);
    $category = CategoryModel::create(['category_name' => 'Software Engineering']);

    $book = BookModel::create([
        'book_author_id' => $author->author_id,
        'book_publisher_id' => $publisher->publisher_id,
        'book_shelf_id' => $shelf->shelf_id,
        'book_category_id' => $category->category_id,
        'book_name' => 'Clean Code',
        'book_isbn' => '978-0132350884',
        'book_stock' => 5,
        'book_description' => 'A Handbook of Agile Software Craftsmanship',
        'book_img' => 'http://example.com/cleancode.jpg',
    ]);

    // Student requests borrowing
    $borrowing = BorrowingModel::storeBorrowing($student->id, [
        'borrowing_notes' => 'Borrowing request',
        'items' => [
            ['book_id' => $book->book_id, 'quantity' => 1]
        ]
    ]);

    // Admin updates status (Marks as returned and sets fine)
    $response = $this->actingAs($admin)
        ->patch(route('admin.borrowing.update', $borrowing->borrowing_id), [
            'borrowing_isreturned' => 1,
            'borrowing_fine' => 5000,
            'borrowing_notes' => 'Returned late, fine charged.',
        ]);

    $response->assertRedirect(route('admin.borrowing'));
    $this->assertDatabaseHas('borrowings', [
        'borrowing_id' => $borrowing->borrowing_id,
        'borrowing_isreturned' => true,
        'borrowing_fine' => 5000,
        'borrowing_notes' => 'Returned late, fine charged.',
    ]);

    // Verify stock is incremented back because the book was returned
    $book->refresh();
    expect($book->book_stock)->toBe(5);
});
