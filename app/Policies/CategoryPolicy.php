<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\StoreKeeper;

class CategoryPolicy
{
    public function view(StoreKeeper $storeKeeper, Category $category)
    {
        return $storeKeeper->id === $category->store_keeper_id;
    }

    public function update(StoreKeeper $storeKeeper, Category $category)
    {
        return $storeKeeper->id === $category->store_keeper_id;
    }

    public function delete(StoreKeeper $storeKeeper, Category $category)
    {
        return $storeKeeper->id === $category->store_keeper_id;
    }
}
