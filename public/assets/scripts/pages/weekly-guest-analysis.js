var report = new Vue({
    data: {
        outlet: null,
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
                url: url("/outlet/get"),
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
            var from = $("input[name=date]")
                .data("daterangepicker")
                .startDate.format("DD-MM-YYYY");
            var to = $("input[name=date]")
                .data("daterangepicker")
                .endDate.format("DD-MM-YYYY");

            $.ajax({
                url: url("/report/weekly-guest-analysis"),
                type: "POST",
                data: {
                    outlet: outlet,
                    from: from,
                    to: to
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
                            `data doesn't exist in range from ${from} to ${to}`
                        );
                    }
                }
            });
        },
        charting: function() {
            var based_on = report.display.based_on;
            var by = report.display.by;
            var spec = report.chart[based_on][by];
            var data = report.reports[based_on];

            var obj = {};
            var categories = [];
            $.each(data, function(date, point) {
                categories.push(moment(date).format("DD-MM-YYYY"));

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
            var from = $("input[name=date]")
                .data("daterangepicker")
                .startDate.format("DD/MM/YYYY");
            var to = $("input[name=date]")
                .data("daterangepicker")
                .endDate.format("DD/MM/YYYY");

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
    $("input[name=date]").daterangepicker({
        dateLimit: {
            days: 6
        },
        maxDate: moment(),
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [
                moment().subtract(1, "days"),
                moment().subtract(1, "days")
            ],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last Week": [
                moment()
                    .subtract(1, "week")
                    .startOf("week")
                    .add(1, "days"),
                moment()
                    .subtract(1, "week")
                    .endOf("week")
                    .add(1, "days")
            ]
        },
        locale: {
            format: "DD/MM/YYYY",
            customRangeLabel: "Custom",
            firstDay: 1
        },
        alwaysShowCalendars: true,
        startDate: moment().subtract(6, "days"),
        showDropdowns: true,
        opens: "center"
    });

    start = setInterval(function() {
        if (report.outlet != null) {
            clearInterval(start);
            report.refresh_report();
        }
    }, 1000);
});
