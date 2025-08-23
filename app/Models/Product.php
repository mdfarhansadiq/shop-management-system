<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock_quantity', 'sku', 'category_id', 'store_keeper_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function storeKeeper()
    {
        return $this->belongsTo(StoreKeeper::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
