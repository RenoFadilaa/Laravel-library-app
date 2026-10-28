<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BookModel extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $primaryKey = 'book_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'book_category_id',
        'book_publisher_id',
        'book_shelf_id',
        'book_author_id',
        'book_name',
        'book_isbn',
        'book_stock',
        'book_description',
        'book_img',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            $book->book_id = (string) Str::uuid();
        });
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryModel::class, 'book_category_id', 'category_id');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(PublisherModel::class, 'book_publisher_id', 'publisher_id');
    }

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(ShelfModel::class, 'book_shelf_id', 'shelf_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(AuthorModel::class, 'book_author_id', 'author_id');
    }

    // Custom Methods
    public static function getAllData()
    {
        // Eager load relationships to prevent N+1 queries as per laravel-best-practices
        return self::with(['category', 'publisher', 'shelf', 'author'])->latest()->paginate(3);
    }

    public static function storeData(array $data)
    {
        return self::create($data);
    }

    public static function updateData($id, array $data)
    {
        $book = self::find($id);
        if ($book) {
            $book->update($data);
            return $book;
        }
        return null;
    }

    public static function destroyData($id)
    {
        $book = self::find($id);
        if ($book) {
            return $book->delete();
        }
        return false;
    }
}
