<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\StoreKeeper;

class ProductPolicy
{
    public function view(StoreKeeper $storeKeeper, Product $product)
    {
        return $storeKeeper->id === $product->store_keeper_id;
    }

    public function update(StoreKeeper $storeKeeper, Product $product)
    {
        return $storeKeeper->id === $product->store_keeper_id;
    }

    public function delete(StoreKeeper $storeKeeper, Product $product)
    {
        return $storeKeeper->id === $product->store_keeper_id;
    }
}
