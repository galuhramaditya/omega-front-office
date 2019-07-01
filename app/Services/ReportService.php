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

    public function monthlyGuestAnalysis(string $outletCd, string $m1, string $m2, string $y1, string $y2)
    {
        $results = $this->reportRepository->monthlyGuestAnalysis($outletCd, $m1, $m2, $y1, $y2);
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
}