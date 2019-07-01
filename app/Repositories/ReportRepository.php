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

    public function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2)
    {
        return Report::monthlyGuestAnalysis($outletCd, $m1, $m2, $y1, $y2);
    }

    public function weeklyGuestAnalysis(string $outletCd, string $date1, string $date2)
    {
        return Report::weeklyGuestAnalysis($outletCd, $date1, $date2);
    }
}