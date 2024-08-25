<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $fillable = ['id', 'author_name', 'book_numbers'];
}
