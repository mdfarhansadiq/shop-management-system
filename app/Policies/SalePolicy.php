<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\StoreKeeper;

class SalePolicy
{
    public function view(StoreKeeper $storeKeeper, Sale $sale)
    {
        return $storeKeeper->id === $sale->store_keeper_id;
    }
}
