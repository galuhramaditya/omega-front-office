var report = new Vue({
    data: {
        reports: null,
        chart: [
            {
                title: "As Date",
                id: "date",
                type: "pie",
                field: "tasdate"
            },
            { title: "Weekly / Day", id: "week", type: "line" },
            { title: "Yearly / Month", id: "month", type: "line" }
        ]
    },
    methods: {
        refresh_report: function() {
            $("#on-print").slideUp("slow");
            $(".loader").slideDown("slow");

            var type = $("select[name=type] option:selected").val();
            var date = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("mm/dd/yyyy");

            $.ajax({
                url: url(`/report/outlet-revenue-analysis`),
                type: "POST",
                data: {
                    date: date
                },
                success: function(response) {
                    $(".loader").slideUp("slow");

                    if (response.hasOwnProperty("data")) {
                        report.reports = response.data;
                        report.chart.map(key => {
                            if (key.type == "pie") {
                                report.pie_charting(key.id, key.field);
                            } else {
                                report.line_charting(key.id);
                            }
                        });

                        $("#on-print").slideDown("slow", function() {
                            scrollTo($("#on-print"));
                        });
                    } else {
                        bootbox.alert(
                            `data doesn't exist on ${date.getFormattedDate(
                                "dd/mm/yyyy"
                            )}`
                        );
                    }
                }
            });
        },
        pie_charting: function(id, field) {
            var data = report.reports[id].data;

            $.each(data, function(i, point) {
                point.name = point.descp;
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
        line_charting: function(id) {
            var data = report.reports[id];
            var series = [];

            $.each(data.data, function(key, value) {
                series.push({
                    name: key,
                    data: value
                });
            });

            Highcharts.chart(id, {
                chart: {
                    type: "line"
                },
                credits: {
                    enabled: false
                },
                title: false,
                xAxis: {
                    categories: data.time
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
            var date = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("mm/yyyy");

            app.print(`${date}`);
        }
    }
});

$(document).ready(function() {
    $("input[name=date]")
        .datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            endDate: "0d",
            orientation: "bottom",
            todayHighlight: true
        })
        .datepicker("setDate", moment().format("DD/MM/YYYY"));

    setTimeout(() => {
        report.refresh_report();
    }, 1000);
});
