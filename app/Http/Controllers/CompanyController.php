<?php

namespace App\Http\Controllers;

use App\Libraries\Response;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    private $getanyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function get()
    {
        $get = $this->companyService->get();

        return Response::success("successfully get code company datas", $get);
    }
}