<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'category_id', 'price', 'img', 'desc'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}