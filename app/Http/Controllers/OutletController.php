<?php

namespace App\Http\Controllers;

use App\Services\OutletService;
use App\Libraries\Response;

class OutletController extends Controller
{
    protected $outletService;

    public function __construct(OutletService $outletService)
    {
        $this->outletService = $outletService;
    }

    public function get()
    {
        $data = $this->outletService->get();
        return Response::success("successfully get outlet data", $data);
    }
}