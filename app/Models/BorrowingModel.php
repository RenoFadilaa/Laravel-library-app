<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BorrowingModel extends Model
{
    use HasFactory;

    protected $table = 'borrowings';

    protected $primaryKey = 'borrowing_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'borrowing_user_id',
        'borrowing_isreturned',
        'borrowing_notes',
        'borrowing_fine',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($borrowing) {
            $borrowing->borrowing_id = (string) Str::uuid();
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'borrowing_user_id', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetailModel::class, 'detail_borrowing_id', 'borrowing_id');
    }

    // Custom Methods
    public static function getAllData()
    {
        return self::with(['user', 'details.book'])->latest()->paginate(3);
    }

    public static function getUserData($userId)
    {
        return self::where('borrowing_user_id', $userId)
            ->with(['details.book'])
            ->latest()
            ->paginate(3);
    }

    public static function storeBorrowing($userId, array $data)
    {
        return DB::transaction(function () use ($userId, $data) {
            // Create Borrowing record
            $borrowing = self::create([
                'borrowing_user_id' => $userId,
                'borrowing_isreturned' => false,
                'borrowing_notes' => $data['borrowing_notes'] ?? null,
                'borrowing_fine' => null,
            ]);

            // Add details
            foreach ($data['items'] as $item) {
                // Decrement book stock
                $book = BookModel::find($item['book_id']);
                if ($book) {
                    if ($book->book_stock < $item['quantity']) {
                        throw new \Exception("Stock for book '{$book->book_name}' is insufficient.");
                    }
                    $book->decrement('book_stock', $item['quantity']);
                }

                BorrowingDetailModel::create([
                    'detail_borrowing_id' => $borrowing->borrowing_id,
                    'detail_book_id' => $item['book_id'],
                    'detail_quantity' => $item['quantity'],
                ]);
            }

            return $borrowing;
        });
    }

    public static function updateBorrowing($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $borrowing = self::find($id);
            if (!$borrowing) {
                return null;
            }

            // If returned status is changing from unreturned (false) to returned (true)
            if (isset($data['borrowing_isreturned']) && $data['borrowing_isreturned'] && !$borrowing->borrowing_isreturned) {
                // Restore book stocks and set details to returned
                foreach ($borrowing->details as $detail) {
                    if (!$detail->detail_isreturned) {
                        $book = BookModel::find($detail->detail_book_id);
                        if ($book) {
                            $book->increment('book_stock', $detail->detail_quantity);
                        }
                        $detail->update(['detail_isreturned' => true]);
                    }
                }
            }
            // If returned status is changing from returned (true) to unreturned (false)
            elseif (isset($data['borrowing_isreturned']) && !$data['borrowing_isreturned'] && $borrowing->borrowing_isreturned) {
                // Re-deduct book stocks and set details to unreturned
                foreach ($borrowing->details as $detail) {
                    if ($detail->detail_isreturned) {
                        $book = BookModel::find($detail->detail_book_id);
                        if ($book) {
                            $book->decrement('book_stock', $detail->detail_quantity);
                        }
                        $detail->update(['detail_isreturned' => false]);
                    }
                }
            }

            $borrowing->update($data);
            return $borrowing;
        });
    }

    public static function returnDetail($detailId)
    {
        return DB::transaction(function () use ($detailId) {
            $detail = BorrowingDetailModel::find($detailId);
            if (!$detail || $detail->detail_isreturned) {
                return null;
            }

            // Restore book stock
            $book = BookModel::find($detail->detail_book_id);
            if ($book) {
                $book->increment('book_stock', $detail->detail_quantity);
            }

            $detail->update(['detail_isreturned' => true]);

            // Check if all details of this borrowing are now returned
            $borrowing = self::find($detail->detail_borrowing_id);
            if ($borrowing) {
                $allReturned = !$borrowing->details()->where('detail_isreturned', false)->exists();
                if ($allReturned) {
                    $borrowing->update(['borrowing_isreturned' => true]);
                }
            }

            return $detail;
        });
    }

    public static function undoReturnDetail($detailId)
    {
        return DB::transaction(function () use ($detailId) {
            $detail = BorrowingDetailModel::find($detailId);
            if (!$detail || !$detail->detail_isreturned) {
                return null;
            }

            // Deduct book stock
            $book = BookModel::find($detail->detail_book_id);
            if ($book) {
                $book->decrement('book_stock', $detail->detail_quantity);
            }

            $detail->update(['detail_isreturned' => false]);

            // Parent borrowing is definitely not fully returned anymore
            $borrowing = self::find($detail->detail_borrowing_id);
            if ($borrowing) {
                $borrowing->update(['borrowing_isreturned' => false]);
            }

            return $detail;
        });
    }

    public static function returnAll($borrowingId)
    {
        return DB::transaction(function () use ($borrowingId) {
            $borrowing = self::find($borrowingId);
            if (!$borrowing) {
                return null;
            }

            foreach ($borrowing->details as $detail) {
                if (!$detail->detail_isreturned) {
                    $book = BookModel::find($detail->detail_book_id);
                    if ($book) {
                        $book->increment('book_stock', $detail->detail_quantity);
                    }
                    $detail->update(['detail_isreturned' => true]);
                }
            }

            $borrowing->update(['borrowing_isreturned' => true]);
            return $borrowing;
        });
    }

    public static function destroyBorrowing($id)
    {
        return DB::transaction(function () use ($id) {
            $borrowing = self::find($id);
            if (!$borrowing) {
                return false;
            }

            // If not returned yet, restore stock when deleting/cancelling
            if (!$borrowing->borrowing_isreturned) {
                foreach ($borrowing->details as $detail) {
                    $book = BookModel::find($detail->detail_book_id);
                    if ($book) {
                        $book->increment('book_stock', $detail->detail_quantity);
                    }
                }
            }

            // Delete details first
            $borrowing->details()->delete();
            return $borrowing->delete();
        });
    }
}
