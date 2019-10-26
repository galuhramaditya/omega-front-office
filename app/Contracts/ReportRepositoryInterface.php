<?php

namespace App\Contracts;

interface ReportRepositoryInterface
{
    public function dayOfWeekGuestAnalysis(string $outletCd, string $refDate1, string $refDate2, string $rptType);
    public function weeklyGuestAnalysis(string $outletCd, string $date1, string $date2);
    public function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2);
    public function yearlyGuestAnalysis(string $outletCd, string $year1, string $year2, string $fb);
    public function playerInHouse(string $outletCd, string $refdt1, string $refdt2, string $usrid, string $type);
    public function outletRevenueAnalysis(string $date);
    public function fbTopSalesQty(string $month, string $year);
    public function fbTopSalesAmount(string $month, string $year);
    public function ytdTopSalesQty(string $date, string $outlet);
    public function ytdTopSalesAmount(string $date, string $outlet);
}
