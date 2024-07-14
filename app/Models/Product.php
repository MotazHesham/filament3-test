<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model{

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'price',
        'is_active',
        'image',
    ];

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}