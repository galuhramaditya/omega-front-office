<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class ViewController extends Controller
{
    public function login()
    {
        return View::make('pages.login');
    }

    public function dashboard()
    {
        return View::make("pages.dashboard.index");
    }

    public function dayOfWeekGuestAnalysis()
    {
        return View::make('pages.day-of-week-guest-analysis.index');
    }

    public function weeklyGuestAnalysis()
    {
        return View::make('pages.weekly-guest-analysis.index');
    }

    public function monthlyGuestAnalysis()
    {
        return View::make('pages.monthly-guest-analysis.index');
    }

    public function yearlyGuestAnalysis()
    {
        return View::make('pages.yearly-guest-analysis.index');
    }

    public function playerInHouse()
    {
        return View::make('pages.player-in-house.index');
    }

    public function accounts()
    {
        return View::make('pages.accounts.index');
    }

    public function roles()
    {
        return View::make('pages.roles.index');
    }

    public function pages()
    {
        return View::make('pages.pages.index');
    }
}