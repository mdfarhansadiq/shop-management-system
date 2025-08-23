<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'store_keeper_id'
    ];

    public function storeKeeper()
    {
        return $this->belongsTo(StoreKeeper::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
