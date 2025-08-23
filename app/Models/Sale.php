<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_number', 'customer_id', 'store_keeper_id', 'total_amount', 'discount', 'tax', 'final_amount'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
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
