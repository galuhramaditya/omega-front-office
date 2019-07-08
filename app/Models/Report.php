<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Report
{
    public static function dayOfWeekGuestAnalysis(string $outletCd, string $refDate1, string $refDate2, string $rptType)
    {
        $results = DB::select('SET NOCOUNT ON; EXEC dbo.GSR_39000r ?,?,?,?', [$outletCd, $refDate1, $refDate2, $rptType]);

        return $results;
    }

    public static function weeklyGuestAnalysis(string $outletCd, string $date1, string $date2)
    {
        $results = [
            "player_status" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_71000r ?,?,?', [$outletCd, $date1, $date2]),
            "gender" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_71100r ?,?,?', [$outletCd, $date1, $date2])
        ];

        return $results;
    }

    public static function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2)
    {
        $results = [
            "player_status" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_71200r ?,?,?,?,?', [$outletCd, $m1, $m2, $y1, $y2]),
            "gender" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_71120r ?,?,?,?,?', [$outletCd, $m1, $m2, $y1, $y2])
        ];

        return $results;
    }

    public static function yearlyGuestAnalysis(string $outletCd, string $year1, string $year2, string $fb)
    {
        $results = DB::select('SET NOCOUNT ON; EXEC dbo.GSR_71500r ?,?,?,?', [$outletCd, $year1, $year2, $fb]);

        return $results;
    }

    public static function playerInHouse(string $outletCd, string $refdt1, string $refdt2, string $usrid, string $type)
    {
        $results = [
            "detail" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_02000r ?,?,?,?,?', [$outletCd, $refdt1, $refdt2, $usrid, $type]),
            "summary" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_02100 ?,?,?,?,?', [$outletCd, $refdt1, $refdt2, $usrid, $type]),
        ];

        return $results;
    }
}