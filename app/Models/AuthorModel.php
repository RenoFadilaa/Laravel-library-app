<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class AuthorModel extends Model
{
    use HasFactory;

    protected $table = 'authors';

    protected $primaryKey = 'author_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'author_name',
        'author_description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($author) {
            $author->author_id = (string) Str::uuid();
        });
    }

    // Custom Methods
    public static function getAuthorsByName(string $author_name)
    {
        $authors = self::where('author_name', 'like', '%' . $author_name . '%')->get();

        return $authors;
    }

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
        $author = self::find($id);
        if ($author) {
            $author->update($data);
            return $author;
        }
        return null;
    }

    public static function destroyData($id)
    {
        $author = self::find($id);
        if ($author) {
            return $author->delete();
        }
        return false;
    }
}