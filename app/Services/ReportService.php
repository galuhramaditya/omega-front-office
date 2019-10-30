<?php

namespace App\Services;

use App\Contracts\ReportRepositoryInterface;
use App\CustomConfig;
use DateTime;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function dayOfWeekGuestAnalysis(string $outletCd, string $refDate1, string $refDate2, string $rptType)
    {
        $results = $this->reportRepository->dayOfWeekGuestAnalysis($outletCd, $refDate1, $refDate2, $rptType);

        if ($results) {
            foreach ($results as $result) {
                $result->nofmbrtotal = $result->nofmbram + $result->nofmbrpm;
                $result->nofgsttotal = $result->nofgstam + $result->nofgstpm;
                $result->noftotal = $result->nofmbrtotal + $result->nofgsttotal;
                $result->nofmbrprctg = ($result->nofmbrtotal / $result->noftotal) * 100;
                $result->nofgstprctg = ($result->nofgsttotal / $result->noftotal) * 100;

                $result->nofavrg = $result->noftotal / $result->period;

                $result->mbramttotal = $result->mbramtam + $result->mbramtpm;
                $result->gstamttotal = $result->gstamtam + $result->gstamtpm;
                $result->amttotal = $result->mbramttotal + $result->gstamttotal;
                $result->mbramtprctg = ($result->mbramttotal / $result->amttotal) * 100;
                $result->gstamtprctg = ($result->gstamttotal / $result->amttotal) * 100;

                $result->amtavrg = $result->amttotal / $result->period;
            }

            array_push($results, $result);

            $num = count($results);
            $num = $num - 1;

            unset($results[$num]);
        }
        return $results;
    }

    public function weeklyGuestAnalysis(string $outletCd, string $date1, string $date2)
    {
        $results = $this->reportRepository->weeklyGuestAnalysis($outletCd, $date1, $date2);
        $arr = [
            [
                "data" => $results["player_status"],
                "key" => "player_status",
                "field" => "plysts",
                "record" => ["GUEST ", "MEMBER"],
            ],
            [
                "data" => $results["gender"],
                "key" => "gender",
                "field" => "gender",
                "record" => ["FEMALE", "MALE"],
            ]
        ];

        foreach ($arr as $result) {
            if ($result["data"]) {
                $data = [];
                $prev = null;
                foreach ($result["data"] as $val) {
                    $key = $val->regDate;
                    $subkey = $val->{$result["field"]};

                    if (isset($data[$key][$subkey])) {
                        $data[$key][$subkey]["cmember"] += $val->cmember;
                        $data[$key][$subkey]["ttlamt2"] += $val->ttlamt2;
                    } else {
                        foreach ($result["record"] as $record) {
                            $data[$key][$record] = $subkey == $record ? [
                                "cmember" => $val->cmember,
                                "ttlamt2" => $val->ttlamt2,
                            ] : [
                                "cmember" => 0,
                                "ttlamt2" => 0,
                            ];
                        }
                    }
                }
                $results[$result["key"]] = $data;
            } else {
                $results[$result["key"]] = null;
            }
        }

        return $results["gender"] == null && $results["player_status"] == null ? null : $results;
    }

    public function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2)
    {
        $results = $this->reportRepository->monthlyGuestAnalysis($outletCd, $m1, $m2, $y1, $y2);
        $arr = [
            [
                "data" => $results["player_status"],
                "key" => "player_status",
                "date" => "rmnth",
                "field" => "plysts",
                "record" => ["GUEST ", "MEMBER"],
            ],
            [
                "data" => $results["gender"],
                "key" => "gender",
                "date" => "mn",
                "field" => "gender",
                "record" => ["FEMALE", "MALE"],
            ]
        ];

        foreach ($arr as $result) {
            if ($result["data"]) {
                $data = [];
                foreach ($result["data"] as $val) {
                    $key = $val->{$result["date"]};
                    $subkey = $val->{$result["field"]};

                    if (isset($data[$key][$subkey])) {
                        $data[$key][$subkey]["cmember"] += $val->cmember;
                        $data[$key][$subkey]["ttlamt2"] += $val->ttlamt2;
                    } else {
                        foreach ($result["record"] as $record) {
                            $data[$key][$record] = $subkey == $record ? [
                                "cmember" => $val->cmember,
                                "ttlamt2" => $val->ttlamt2,
                            ] : [
                                "cmember" => 0,
                                "ttlamt2" => 0,
                            ];
                        }
                    }
                }
                $results[$result["key"]] = $data;
            } else {
                $results[$result["key"]] = null;
            }
        }

        return $results["gender"] == null && $results["player_status"] == null ? null : $results;
    }

    public function yearlyGuestAnalysis(string $outletCd, string $year1, string $year2, string $fb)
    {
        $results = $this->reportRepository->yearlyGuestAnalysis($outletCd, $year1, $year2, $fb);

        $data = [];
        foreach ($results as $result) {
            $bln = (string) (int) $result->Bln;
            $data[$bln]["player"]["day"] = (float) $result->PD;
            $data[$bln]["amount"]["pers"] = (float) $result->PS;
            for ($i = 0; $i <= $year2 - $year1; $i++) {
                $field = 5 - $i;
                $year = $year2 - $i;
                $data[$bln]["player"][$year] = (float) $result->{"TH" . $field . "P"};
                $data[$bln]["amount"][$year] = (float) $result->{"TH" . $field . "A"};
            }
        }

        return $data;
    }

    public function playerInHouse(string $outletCd, string $refdt1, string $refdt2, string $usrid, string $type)
    {
        $results = $this->reportRepository->playerInHouse($outletCd, $refdt1, $refdt2, $usrid, $type);

        if ($results["summary"]) {
            $ampm = ["A", "M", "total"];

            $data = [];
            foreach ($results["summary"] as $summary) {
                $key = $summary->gsttypenm;
                $subkey = $summary->ampm;
                $male = (float) $summary->cmale;
                $female = (float) $summary->cfemale;
                $amount = (float) $summary->ttlamt2;

                if (isset($data[$key][$subkey])) {
                    $data[$key][$subkey]["male"] += $male;
                    $data[$key][$subkey]["female"] += $female;
                    $data[$key][$subkey]["amount"] += $amount;
                    $data[$key]["total"]["male"] += $male;
                    $data[$key]["total"]["female"] += $female;
                    $data[$key]["total"]["amount"] += $amount;
                } else {
                    $data[$key]["holes"] = $summary->holes;
                    foreach ($ampm as $ap) {
                        $data[$key][$ap] = $subkey == $ap || $ap == "total" ? [
                            "male" => $male,
                            "female" => $female,
                            "amount" => $amount,
                        ] : [
                            "male" => 0,
                            "female" => 0,
                            "amount" => 0,
                        ];
                    }
                }
            }
            $flight = $results["summary"][0]->ttlflight;
            $results["summary"] = [];
            $results["summary"]["data"] = $data;
            $results["summary"]["flight"] = $flight;
        }

        if (!$results["detail"] || !$results["summary"]) {
            $results = null;
        }

        return $results;
    }

    public function outletRevenueAnalysis(string $date)
    {
        $results = $this->reportRepository->outletRevenueAnalysis($date);

        if ($results) {
            $date = [
                "tasdate" => 0,
                "tmonthly" => 0,
                "tweekly" => 0,
                "tyearly" => 0,
            ];

            $date["data"] = collect($results["date"])->map(function ($key) use (&$date) {
                $key->tasdate = (float) $key->tasdate;
                $key->tmonthly = (float) $key->tmonthly;
                $key->tweekly = (float) $key->tweekly;
                $key->tyearly = (float) $key->tyearly;

                $date["tasdate"] += $key->tasdate;
                $date["tmonthly"] += $key->tmonthly;
                $date["tweekly"] += $key->tweekly;
                $date["tyearly"] += $key->tyearly;

                return $key;
            });

            $results["date"] = $date;

            $week = [
                "data" => [],
                "time" => []
            ];
            collect($results["week"])->map(function ($key) use (&$week) {
                $datex = date_format(new DateTime($key->datex), "d/m/Y");
                if (!in_array($datex, $week["time"])) {
                    array_push($week["time"], $datex);
                }

                if (!isset($week["data"][$key->descp])) {
                    $week["data"][$key->descp] = [];
                }

                array_push($week["data"][$key->descp], (float) $key->tamount);
            });

            $results["week"] = $week;

            $month = [
                "data" => [],
                "time" => []
            ];
            collect($results["month"])->map(function ($key) use (&$month) {
                if (!in_array($key->mmonth, $month["time"])) {
                    array_push($month["time"], $key->mmonth);
                }

                if (!isset($month["data"][$key->descp])) {
                    $month["data"][$key->descp] = [];
                }

                array_push($month["data"][$key->descp], (float) $key->tamount);
            });

            $results["month"] = $month;
        }

        return $results;
    }

    public function fbTopSales(string $month, string $year, string $type)
    {
        $results = $this->reportRepository->{"fbTopSales$type"}($month, $year);

        if ($results) {
            $grp1 = CustomConfig::$grp1;
            $grp2 = CustomConfig::$grp2;

            $data = [];

            foreach ($results as $result) {
                $key = $grp1[$result->Grp1 - 1];
                $subkey = $grp2[$result->Grp2 - 1];
                $title = $result->ServNm;
                $date = (int) date_format(new DateTime($result->RefDt), "d");

                if (!isset($data[$key][$subkey][$title])) {
                    $data[$key][$subkey][$title] = [
                        "total" => (float) $result->TOP,
                    ];
                }

                $data[$key][$subkey][$title]["data"][$date] = (float) $result->Qty;
            }

            $results = $data;
        }

        return $results;
    }

    public function ytdTopSales(string $date, string $outlet, string $type)
    {
        $results = $this->reportRepository->{"ytdTopSales$type"}($date, $outlet);

        if ($results) {
            $key = $results[0]->descp;
            $data = [
                $key => [
                    "total_ytd" => 0,
                    "total_mtd" => 0,
                    "total_date" => 0,
                ]
            ];

            foreach ($results as $result) {
                $subkey = $result->categ;
                $ytd = (float) $result->tyearly;
                $mtd = (float) $result->tmonthly;
                $date = (float) $result->tasdate;

                if (!isset($data[$key]["data"][$subkey])) {
                    $data[$key]["data"][$subkey] = [
                        "data" => [],
                        "total_ytd" => 0,
                        "total_mtd" => 0,
                        "total_date" => 0,
                    ];
                }

                array_push($data[$key]["data"][$subkey]["data"], [
                    "code" => $result->servcd,
                    "description" => $result->servnm,
                    "ytd" => $ytd,
                    "mtd" => $mtd,
                    "date" => $date,
                ]);
                $data[$key]["data"][$subkey]["total_ytd"] += $ytd;
                $data[$key]["data"][$subkey]["total_mtd"] += $mtd;
                $data[$key]["data"][$subkey]["total_date"] += $date;
                $data[$key]["total_ytd"] += $ytd;
                $data[$key]["total_mtd"] += $mtd;
                $data[$key]["total_date"] += $date;
            }

            $results = $data;
        }

        return $results;
    }
}
