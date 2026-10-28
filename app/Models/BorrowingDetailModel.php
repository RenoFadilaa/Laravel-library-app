<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BorrowingDetailModel extends Model
{
    use HasFactory;

    protected $table = 'borrowing_details';

    protected $primaryKey = 'detail_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'detail_book_id',
        'detail_borrowing_id',
        'detail_quantity',
        'detail_isreturned',
    ];

    protected $casts = [
        'detail_isreturned' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detail) {
            $detail->detail_id = (string) Str::uuid();
        });
    }

    // Relationships
    public function book(): BelongsTo
    {
        return $this->belongsTo(BookModel::class, 'detail_book_id', 'book_id');
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(BorrowingModel::class, 'detail_borrowing_id', 'borrowing_id');
    }
}
