<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\StoreKeeper;

class CustomerPolicy
{
    public function view(StoreKeeper $storeKeeper, Customer $customer)
    {
        return $storeKeeper->id === $customer->store_keeper_id;
    }

    public function update(StoreKeeper $storeKeeper, Customer $customer)
    {
        return $storeKeeper->id === $customer->store_keeper_id;
    }

    public function delete(StoreKeeper $storeKeeper, Customer $customer)
    {
        return $storeKeeper->id === $customer->store_keeper_id;
    }
}
