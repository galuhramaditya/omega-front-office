<?php

namespace App\Repositories;

use App\Contracts\ReportRepositoryInterface;
use App\Models\Report;

class ReportRepository implements ReportRepositoryInterface
{
    public function dayOfWeekGuestAnalysis(string $outletCd, string $refDate1, string $refDate2, string $rptType)
    {
        return Report::dayOfWeekGuestAnalysis($outletCd, $refDate1, $refDate2, $rptType);
    }

    public function weeklyGuestAnalysis(string $outletCd, string $date1, string $date2)
    {
        return Report::weeklyGuestAnalysis($outletCd, $date1, $date2);
    }

    public function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2)
    {
        return Report::monthlyGuestAnalysis($outletCd, $m1, $m2, $y1, $y2);
    }

    public function yearlyGuestAnalysis(string $outletCd, string $year1, string $year2, string $fb)
    {
        return Report::yearlyGuestAnalysis($outletCd, $year1, $year2, $fb);
    }

    public function playerInHouse(string $outletCd, string $refdt1, string $refdt2, string $usrid, string $type)
    {
        return Report::playerInHouse($outletCd, $refdt1, $refdt2, $usrid, $type);
    }

    public function outletRevenueAnalysis(string $date)
    {
        return Report::outletRevenueAnalysis($date);
    }

    public function fbTopSalesQty(string $month, string $year)
    {
        return Report::fbTopSalesQty($month, $year);
    }

    public function fbTopSalesAmount(string $month, string $year)
    {
        return Report::fbTopSalesAmount($month, $year);
    }

    public function ytdTopSalesQty(string $date, string $outlet)
    {
        return Report::ytdTopSalesQty($date, $outlet);
    }

    public function ytdTopSalesAmount(string $date, string $outlet)
    {
        return Report::ytdTopSalesAmount($date, $outlet);
    }
}
