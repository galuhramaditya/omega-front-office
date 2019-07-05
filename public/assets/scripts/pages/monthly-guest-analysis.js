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
        display: {
            based_on: "player_status",
            by: "amount"
        },
        chart: {
            player_status: {
                player: {
                    title: "Player by Player Status",
                    hint: "player",
                    field: "cmember"
                },
                amount: {
                    title: "Amount by Player Status",
                    hint: "amount",
                    field: "ttlamt2"
                }
            },
            gender: {
                player: {
                    title: "Player by Gender",
                    hint: "player",
                    field: "cmember"
                },
                amount: {
                    title: "Amount by Gender",
                    hint: "amount",
                    field: "ttlamt2"
                }
            }
        }
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
            $("#on-print").slideUp("slow");
            $("#select-display").slideDown("slow");
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

                        $("#on-print").slideDown("slow", function() {
                            report.charting();
                            scrollTo($("#on-print"));
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
            var based_on = report.display.based_on;
            var by = report.display.by;
            var spec = report.chart[based_on][by];
            var data = report.reports[based_on];

            var obj = {};
            var categories = [];
            $.each(data, function(date, point) {
                categories.push(`${date.substr(4)}-${date.substr(0, 4)}`);

                $.each(point, function(field, value) {
                    if (!obj.hasOwnProperty(field)) {
                        obj[field] = { name: field, data: [] };
                    }

                    obj[field].data.push(parseFloat(value[spec.field]));
                });
            });

            var series = [];
            $.each(obj, function(i, point) {
                series.push(point);
            });

            Highcharts.chart("chart-display", {
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
        },
        handle_display: function(display) {
            $.each(display, function(index, value) {
                report.display[index] = value;
            });
            report.charting();
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
