<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'store_keeper_id'
    ];

    public function storeKeeper()
    {
        return $this->belongsTo(StoreKeeper::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
