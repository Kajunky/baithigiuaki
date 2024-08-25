<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategories extends Model
{
    use HasFactory;

    protected $table = 'book_categories';

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'category_name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
