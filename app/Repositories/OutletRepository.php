<?php

namespace App\Repositories;

use App\Contracts\OutletRepositoryInterface;
use App\Models\Outlet;

class OutletRepository implements OutletRepositoryInterface
{
    public function get()
    {
        return Outlet::all();
    }
}