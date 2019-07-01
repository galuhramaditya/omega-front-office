<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Services\OutletService;
use App\Services\UserService;
use Illuminate\Support\Facades\View;

class ViewController extends Controller
{
    protected $reportService;
    protected $outletService;
    protected $userService;

    public function __construct(ReportService $reportService, OutletService $outletService, UserService $userService)
    {
        $this->reportService    = $reportService;
        $this->outletService    = $outletService;
        $this->userService      = $userService;
    }

    public function login()
    {
        return View::make('pages.login');
    }

    public function index()
    {
        return View::make("layouts.app");
    }

    public function dayOfWeekGuestAnalysis()
    {
        return View::make('pages.day-of-week-guest-analysis.index');
    }

    public function monthlyGuestAnalysis()
    {
        return View::make('pages.monthly-guest-analysis.index');
    }

    public function weeklyGuestAnalysis()
    {
        return View::make('pages.weekly-guest-analysis.index');
    }

    // public function account(Request $request)
    // {
    //     $users = $this->userService->get();
    //     $user   = $this->userService->findOneBy(["api_token" => $request->api_token]);
    //     return View::make('pages.account', ['users' => $users, 'admin' => $user->admin, "username" => $user->username]);
    // }
}