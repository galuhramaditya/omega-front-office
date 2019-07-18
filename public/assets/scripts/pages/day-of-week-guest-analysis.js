var report = new Vue({
    data: {
        outlet: null,
        reports: null,
        total: null,
        chart: [
            {
                title: "Total Average Player",
                id: "chart_player",
                field: "nofavrg"
            },
            {
                title: "Total Revenue",
                id: "chart_revenue",
                field: "amttotal"
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
            $("#on-print").slideUp("slow");
            $(".loader").slideDown("slow");

            var outlet = $("select[name=outlet] option:selected").val();
            var from = $("input[name=date]")
                .data("daterangepicker")
                .startDate.format("DD-MM-YYYY");
            var to = $("input[name=date]")
                .data("daterangepicker")
                .endDate.format("DD-MM-YYYY");

            $.ajax({
                url: "/report/day-of-week-guest-analysis",
                type: "POST",
                data: {
                    outlet: outlet,
                    from: from,
                    to: to
                },
                success: function(response) {
                    $(".loader").slideUp("slow");

                    if (response.hasOwnProperty("data")) {
                        report.total = {};
                        report.reports = response.data;

                        $("#on-print").slideDown("slow", function() {
                            $.each(report.chart, function(i, point) {
                                report.charting(point.id, point.field);
                            });

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
        output: function(key, index, avg = false) {
            var tag_total = $("tr#total");

            if (_.size(report.total) == 0) {
                tag_total.find("td").remove();
            }

            if (tag_total.find("td").length == 0) {
                tag_total.append("<td class='text-left'>Total</td>");
            }

            var data = parseFloat(
                String(report.reports[index][key])
                    .split(",")
                    .join("")
            );

            if (!report.total.hasOwnProperty(key)) {
                report.total[key] = data;
                tag_total.append(`<td data="${key}">${data}</td>`);
            } else {
                report.total[key] += data;
                var total = report.total[key];

                if (avg) {
                    total /= index + 1;
                }

                tag_total.find(`td[data="${key}"]`).html(
                    total.toLocaleString(undefined, {
                        maximumFractionDigits: 2
                    })
                );
            }
            return data.toLocaleString(undefined, { maximumFractionDigits: 2 });
        },
        charting: function(id, field) {
            var data = report.reports;

            $.each(data, function(i, point) {
                point.name = point.dayname;
                point.y = point[field];
            });

            Highcharts.chart(id, {
                chart: {
                    type: "pie"
                },
                credits: {
                    enabled: false
                },
                title: false,
                tooltip: {
                    pointFormat: "<b>{point.y}</b> ({point.percentage:.2f}%)"
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: "pointer",
                        dataLabels: {
                            enabled: true,
                            format:
                                "<b>{point.name}</b>: {point.percentage:.2f}%"
                        }
                    }
                },
                series: [
                    {
                        colorByPoint: true,
                        data: data
                    }
                ]
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
        }
    }
});

$(document).ready(function() {
    report.refresh_outlet();
    $("input[name=date]").daterangepicker({
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
            ],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "This Year": [moment().startOf("year"), moment()],
            "Last 365 Days": [moment().subtract(364, "days"), moment()],
            "Last Year": [
                moment()
                    .subtract(1, "year")
                    .startOf("year"),
                moment()
                    .subtract(1, "year")
                    .endOf("year")
            ]
        },
        locale: {
            format: "DD/MM/YYYY",
            customRangeLabel: "Custom",
            firstDay: 1
        },
        alwaysShowCalendars: true,
        startDate: moment().startOf("month"),
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
