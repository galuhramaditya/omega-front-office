<?php

namespace App\Contracts;

interface ReportRepositoryInterface
{
    public function dayOfWeekGuestAnalysis(string $outletCd, string $refDate1, string $refDate2, string $rptType);
    public function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2);
    public function weeklyGuestAnalysis(string $outletCd, string $date1, string $date2);
}