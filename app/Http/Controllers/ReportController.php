<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Services\OutletService;
use App\Libraries\Response;

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

    public function monthlyGuestAnalysis(Request $request)
    {
        $get = $this->reportService->weeklyGuestAnalysis($request->outlet, $request->from, $request->to);
        return Response::success("succeffully get report data", $get);
    }

    public function weeklyGuestAnalysis(Request $request)
    {
        $get = $this->reportService->weeklyGuestAnalysis($request->outlet, $request->from, $request->to);
        return Response::success("succeffully get report data", $get);
    }
}