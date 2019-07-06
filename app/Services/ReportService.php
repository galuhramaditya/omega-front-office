<?php

namespace App\Services;

use App\Contracts\ReportRepositoryInterface;

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

                $arrnof = array($result->nofmbram, $result->nofmbrpm, $result->nofgstam, $result->nofgsttotal);
                $result->nofavrg = ceil(array_sum($arrnof) / count($arrnof));

                $result->mbramttotal = $result->mbramtam + $result->mbramtpm;
                $result->gstamttotal = $result->gstamtam + $result->gstamtpm;
                $result->amttotal = $result->mbramttotal + $result->gstamttotal;
                $result->mbramtprctg = ($result->mbramttotal / $result->amttotal) * 100;
                $result->gstamtprctg = ($result->gstamttotal / $result->amttotal) * 100;

                $arramt = array($result->mbramtam, $result->mbramtpm, $result->gstamtam, $result->gstamtpm);
                $result->amtavrg = ceil(array_sum($arramt) / count($arramt));
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

    // public function balanceSheet(string $cocd, string $cyear, string $cmonth, string $fDepCd, string $tDepCd, string $bsType)
    // {
    //     $results = $this->reportRepository->balanceSheet($cocd, $cyear, $cmonth, $fDepCd, $tDepCd, $bsType);

    //     return $results;
    // }
}