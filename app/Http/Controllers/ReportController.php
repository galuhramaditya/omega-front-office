<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Services\OutletService;
use App\Libraries\Response;
use App\Libraries\Validation;

class ReportController extends Controller
{
    protected $reportService;
    protected $outletService;

    public function __construct(ReportService $reportService, OutletService $outletService)
    {
        $this->reportService = $reportService;
        $this->outletService = $outletService;
    }

    public function dayOfWeekGuestAnalysis(Request $request)
    {
        $get = $this->reportService->dayOfWeekGuestAnalysis($request->outlet, $request->from, $request->to, 'all');
        return Response::success("succeffully get report data", $get);
    }

    public function weeklyGuestAnalysis(Request $request)
    {
        $get = $this->reportService->weeklyGuestAnalysis($request->outlet, $request->from, $request->to);
        return Response::success("succeffully get report data", $get);
    }

    public function monthlyGuestAnalysis(Request $request)
    {
        $get = $this->reportService->monthlyGuestAnalysis($request->outlet, $request->from_month, $request->to_month, $request->from_year, $request->to_year);
        return Response::success("succeffully get report data", $get);
    }

    public function yearlyGuestAnalysis(Request $request)
    {
        if ($request->to - $request->from > 4) {
            return Response::error("request is not complete", ["date" => "The maximum range of years is 4 years"]);
        }

        $get = $this->reportService->yearlyGuestAnalysis($request->outlet, $request->from, $request->to, "");
        return Response::success("succeffully get report data", $get);
    }

    public function playerInHouse(Request $request)
    {
        $get = $this->reportService->playerInHouse($request->outlet, $request->date, $request->date, $request->username, "All");
        return Response::success("succeffully get report data", $get);
    }

    public function balanceSheet(Request $request)
    {
        $get = $this->reportService->balanceSheet($request->company, $request->year, $request->month, "", "", "T");
        return Response::success("succeffully get report data", $get);
    }
}