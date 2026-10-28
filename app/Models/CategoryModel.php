<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'category_name',
        'category_description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->category_id = (string) Str::uuid();
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
        $category = self::find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public static function destroyData($id)
    {
        $category = self::find($id);
        if ($category) {
            return $category->delete();
        }
        return false;
    }
}
