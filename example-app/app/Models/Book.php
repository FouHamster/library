<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function author(): HasOne
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function gener(): HasOne
    {
        return $this->hasOne(Gener::class, 'id', 'gener_id');
    }
}
