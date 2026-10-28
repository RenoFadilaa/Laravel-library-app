<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PublisherModel extends Model
{
    use HasFactory;

    protected $table = 'publishers';

    protected $primaryKey = 'publisher_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'publisher_name',
        'publisher_description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publisher) {
            $publisher->publisher_id = (string) Str::uuid();
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
        $publisher = self::find($id);
        if ($publisher) {
            $publisher->update($data);
            return $publisher;
        }
        return null;
    }

    public static function destroyData($id)
    {
        $publisher = self::find($id);
        if ($publisher) {
            return $publisher->delete();
        }
        return false;
    }
}
