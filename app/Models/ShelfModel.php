<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ShelfModel extends Model
{
    use HasFactory;

    protected $table = 'shelfs';

    protected $primaryKey = 'shelf_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'shelf_name',
        'shelf_position',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shelf) {
            $shelf->shelf_id = (string) Str::uuid();
        });
    }

    // Custom Methods
    public static function getAllData()
    {
        return self::latest()->paginate(3);
    }

    public static function storeData(array $data)
    {
        return self::create($data);
    }

    public static function updateData($id, array $data)
    {
        $shelf = self::find($id);
        if ($shelf) {
            $shelf->update($data);
            return $shelf;
        }
        return null;
    }

    public static function destroyData($id)
    {
        $shelf = self::find($id);
        if ($shelf) {
            return $shelf->delete();
        }
        return false;
    }
}
