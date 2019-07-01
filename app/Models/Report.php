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

    public static function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2)
    {
        $results = [
            "player_status" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_71000r ?,?,?', [$outletCd, $date1, $date2]),
            "gender" => DB::select('SET NOCOUNT ON; EXEC dbo.GSR_71100r ?,?,?', [$outletCd, $date1, $date2])
        ];

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
}