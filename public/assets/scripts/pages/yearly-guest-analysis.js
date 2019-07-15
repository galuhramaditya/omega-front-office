var report = new Vue({
    data: {
        outlet: null,
        range: {
            from: null,
            to: null
        },
        total: null,
        reports: null,
        table: [
            {
                title: "No. of Player",
                field: "player",
                header: null
            },
            {
                title: "Income from Player",
                field: "amount",
                header: null
            }
        ],
        chart: [
            {
                title: "No. of Player",
                hint: "person",
                id: "nop_player_status",
                field: "player",
                except: "day",
                icon: ""
            },
            {
                title: "Income from Player",
                hint: "Rp. 1,000",
                id: "amount_player_status",
                field: "amount",
                except: "pers",
                icon: ""
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
            $("#select-display").slideDown("slow");
            $(".loader").slideDown("slow");

            var outlet = $("select[name=outlet] option:selected").val();
            var from = report.range.from;
            var to = report.range.to;

            hideFormAlert();

            $.ajax({
                url: "/report/yearly-guest-analysis",
                type: "POST",
                data: {
                    outlet: outlet,
                    from: from,
                    to: to
                },
                success: function(response) {
                    $(".loader").slideUp("slow");
                    if (response.hasOwnProperty("data")) {
                        report.total = { amount: [], player: [] };
                        report.reports = response.data;

                        $("#on-print").slideDown("slow", function() {
                            report.handle_charting("column");
                            $.each(report.table, function(i, point) {
                                report.tabling(point);
                            });

                            scrollTo($("#on-print"));
                        });
                    } else {
                        bootbox.alert(
                            `data doesn't exist in range from ${from} to ${to}`
                        );
                    }
                },
                error: function(response) {
                    showFormAlert($("form"), response.responseJSON.data);
                }
            });
        },
        tabling: function(table) {
            table.header = [];
            $.each(report.reports, function(month, data) {
                $.each(data[table.field], function(point) {
                    if (
                        Object.keys(report.reports[month][table.field]).pop() ==
                        point
                    ) {
                        point = `${report.range.to}/p.${point}`;
                    }
                    if ($.inArray(point, table.header) == -1) {
                        table.header.push(point);
                    }
                });
            });
        },
        output: function(key, field, month) {
            var tag_total = $(`tr#total-${field}`);
            var data = report.reports[month][field][key];

            if (report.total[field].length == 0) {
                tag_total.find("td").remove();
            }

            if (tag_total.find("td").length == 0) {
                tag_total.append("<td>Total</td>");
            }

            if (!report.total[field].hasOwnProperty(key)) {
                report.total[field][key] = data;

                if (Object.keys(report.reports[month][field]).pop() == key) {
                    tag_total.append("<td></td>");
                } else {
                    tag_total.append(`<td data=${key}>${data}</td>`);
                }
            } else {
                report.total[field][key] += data;
                var total = report.total[field][key];

                tag_total
                    .find(`td[data=${key}]`)
                    .html(
                        total.toLocaleString(undefined, {
                            maximumFractionDigits: 2
                        })
                    );
            }
            return data.toLocaleString(undefined, { maximumFractionDigits: 2 });
        },
        charting: function(spec, type) {
            var categories = [];
            var data = {};
            var series = [];

            $.each(report.reports, function(month, field) {
                categories.push(month);
                $.each(field[spec.field], function(year, point) {
                    if (year != spec.except) {
                        if (!data.hasOwnProperty(year)) {
                            data[year] = { name: year, data: [] };
                        }
                        data[year].data.push(point);
                    }
                });
            });

            $.each(data, function(i, point) {
                series.push(point);
            });

            Highcharts.chart(spec.id, {
                chart: {
                    type: type
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
            var from = report.range.from;
            var to = report.range.to;

            app.print(`${outlet} (${from} - ${to})`);
        },
        handle_charting: function(type) {
            report.total = { amount: [], player: [] };

            $.each(report.chart, function(i, point) {
                point.icon = type == "column" ? "bar" : type;
                report.charting(point, type);
            });
        }
    }
});

$(document).ready(function() {
    report.refresh_outlet();
    $("input[name=date]").daterangepicker(
        {
            ranges: {},
            startDate: moment().subtract(3, "year"),
            expanded: true,
            orientation: "left",
            forceUpdate: true,
            locale: {
                inputFormat: "YYYY"
            },
            periods: ["year"]
        },
        function(startDate, endDate, period) {
            report.range.from = startDate.format("YYYY");
            report.range.to = endDate.format("YYYY");

            $(this).val(
                startDate.format("YYYY") + " – " + endDate.format("YYYY")
            );
        }
    );

    start = setInterval(function() {
        if (report.outlet != null) {
            clearInterval(start);
            report.refresh_report();
        }
    }, 1000);
});
