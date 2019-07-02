var report = new Vue({
    data: {
        outlet: null,
        range: {
            from_month: null,
            to_month: null,
            from_year: null,
            to_year: null
        },
        reports: null,
        chart: [
            {
                title: "Player by Player Status",
                hint: "player",
                id: "nop_player_status",
                data: "player_status",
                field: "cmember"
            },
            {
                title: "Amount by Player Status",
                hint: "amount",
                id: "amount_player_status",
                data: "player_status",
                field: "ttlamt2"
            },
            {
                title: "Player by Gender",
                hint: "player",
                id: "nop_gender",
                data: "gender",
                field: "cmember"
            },
            {
                title: "Amount by Gender",
                hint: "amount",
                id: "amount_gender",
                data: "gender",
                field: "ttlamt2"
            }
        ]
    },
    methods: {
        refresh_outlet: function() {
            $.ajax({
                type: "get",
                url: "/outlet/get",
                success: function(response) {
                    report.outlet = response.data;
                }
            });
        },
        refresh_report: function() {
            $(".on-print").slideUp("slow");
            $(".loader").slideDown("slow");
            var outlet = $("select[name=outlet] option:selected").val();
            var from_month = report.range.from_month;
            var to_month = report.range.to_month;
            var from_year = report.range.from_year;
            var to_year = report.range.to_year;

            $.ajax({
                url: "/report/monthly-guest-analysis",
                type: "POST",
                data: {
                    outlet: outlet,
                    from_month: from_month,
                    to_month: to_month,
                    from_year: from_year,
                    to_year: to_year
                },
                success: function(response) {
                    $(".loader").slideUp("slow");
                    if (response.hasOwnProperty("data")) {
                        report.reports = response.data;

                        $(".on-print").slideDown("slow", function() {
                            $.each(report.chart, function(i, point) {
                                report.charting(point);
                            });

                            scrollTo($(".on-print"));
                        });
                    } else {
                        bootbox.alert(
                            `data doesn't exist in range from ${from_month}-${from_year} to ${to_month}-${to_year}`
                        );
                    }
                }
            });
        },
        charting: function(spec) {
            var data = report.reports[spec.data];
            var categories = [];
            var obj = {};
            var series = [];

            $.each(data, function(i, point) {
                categories.push(i);
                $.each(point, function(j, val) {
                    if (!obj.hasOwnProperty(j)) {
                        obj[j] = { name: j, data: [] };
                    }
                    obj[j].data.push(parseFloat(val[spec.field]));
                });
            });

            $.each(obj, function(i, point) {
                series.push(point);
            });

            Highcharts.chart(spec.id, {
                chart: {
                    type: "line"
                },
                credits: {
                    enabled: false
                },
                title: false,
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: spec.hint
                    }
                },
                plotOptions: {
                    line: {
                        cursor: "pointer"
                    }
                },
                series: series
            });
        },
        print: function() {
            var outlet = $("select[name=outlet] option:selected").attr("name");
            var from = `${report.range.from_month}/${report.range.from_year}`;
            var to = `${report.range.to_month}/${report.range.to_year}`;
            app.print(`${outlet} (${from} - ${to})`);
        }
    }
});

$(document).ready(function() {
    report.refresh_outlet();
    $("input[name=date]").daterangepicker(
        {
            ranges: {
                "Last 12 Month": [moment().subtract(12, "month"), moment()],
                "Last Year": [
                    moment()
                        .subtract(1, "year")
                        .startOf("year")
                        .add(1, "month"),
                    moment()
                        .subtract(1, "year")
                        .endOf("year")
                ]
            },
            startDate: moment()
                .startOf("year")
                .add(1, "month"),
            expanded: true,
            orientation: "left",
            forceUpdate: true,
            locale: {
                inputFormat: "MM/YYYY"
            },
            periods: ["month", "quarter", "year"]
        },
        function(startDate, endDate, period) {
            report.range.from_month = startDate.format("MM");
            report.range.to_month = endDate.format("MM");
            report.range.from_year = startDate.format("YYYY");
            report.range.to_year = endDate.format("YYYY");

            $(this).val(
                startDate.format("MM/YYYY") + " – " + endDate.format("MM/YYYY")
            );
        }
    );
});
