<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookProperty extends Model
{
    use HasFactory;

    protected $table = 'book_properties';

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'title', 'author_id', 'category_id', 'publisher', 'publish_year', 'quantity'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function search(string | null $search)
    {
        $book_properties = BookProperty::join('book_categories', 'book_properties.category_id', '=', 'book_categories.id')
            ->join('authors', 'book_properties.author_id', '=', 'authors.id')
            ->select('book_properties.*', 'book_categories.category_name');

        if($search) {
            $book_properties->where(function ($query) use ($search) {
                $query->where("book_properties.title", "like", "%" . $search . "%")
                    ->orWhere("book_categories.id", "like", "%" . $search . "%")
                    ->orWhere("book_properties.author_id", "like", "%" . $search . "%");
                });
            }
            // dd($book_properties);
        return $book_properties;
    }
}
