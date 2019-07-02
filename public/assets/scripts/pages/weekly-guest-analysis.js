var report = new Vue({
    data: {
        outlet: null,
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
            var from = $("input[name=date]")
                .data("daterangepicker")
                .startDate.format("DD-MM-YYYY");
            var to = $("input[name=date]")
                .data("daterangepicker")
                .endDate.format("DD-MM-YYYY");

            $.ajax({
                url: "/report/weekly-guest-analysis",
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

                        $(".on-print").slideDown("slow", function() {
                            $.each(report.chart, function(i, point) {
                                report.charting(point);
                            });

                            scrollTo($(".on-print"));
                        });
                    } else {
                        bootbox.alert(
                            `data doesn't exist in range from ${from} to ${to}`
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
                categories.push(moment(i).format("DD-MM-YYYY"));
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
            var from = $("input[name=date]")
                .data("daterangepicker")
                .startDate.format("DD-MM-YYYY");
            var to = $("input[name=date]")
                .data("daterangepicker")
                .endDate.format("DD-MM-YYYY");
            app.print(`${outlet} (${from} - ${to})`);
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
});
