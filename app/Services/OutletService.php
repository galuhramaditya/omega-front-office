<?php

namespace App\Services;

use App\Contracts\OutletRepositoryInterface;

class OutletService
{
    protected $outletRepository;

    public function __construct(OutletRepositoryInterface $outletRepository)
    {
        $this->outletRepository = $outletRepository;
    }

    public function get()
    {
        $results = $this->outletRepository->get();
        return $results;
    }
}