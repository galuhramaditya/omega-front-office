var dashboard = new Vue({
    data: {
        outlet: null,
        chart: {
            display: [],
            list: {
                "day-of-week-guest-analysis": {
                    seq: 1,
                    title: "Total Revenue",
                    field: "amttotal",
                    from: moment().startOf("month"),
                    to: moment(),
                    date_format: "DD/MM/YYYY"
                },
                "weekly-guest-analysis": {
                    seq: 2,
                    title: "Amount Player by Status",
                    field: "ttlamt2",
                    hint: "amount",
                    based_on: "player_status",
                    by: "amount",
                    from: moment().subtract(6, "days"),
                    to: moment(),
                    date_format: "DD/MM/YYYY"
                },
                "monthly-guest-analysis": {
                    seq: 3,
                    title: "Amount Player by Status",
                    field: "ttlamt2",
                    hint: "amount",
                    based_on: "player_status",
                    by: "amount",
                    from: moment()
                        .startOf("year")
                        .add(1, "month"),
                    to: moment(),
                    date_format: "MM/YYYY"
                },
                "yearly-guest-analysis": {
                    seq: 4,
                    title: "Income from Player",
                    field: "amount",
                    hint: "Rp. 1,000",
                    except: "pers",
                    from: moment().subtract(3, "year"),
                    to: moment(),
                    date_format: "YYYY"
                },
                "outlet-revenue-analysis": {
                    seq: 5,
                    title: "Yearly / Month",
                    date: moment("01/04/2018", "DD/MM/YYYY"),
                    date_format: "MM/YYYY"
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
                    dashboard.outlet = response.data;
                }
            });
        },
        "outlet-revenue-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];

            dashboard.loading_down(func);

            $.ajax({
                url: url(`/report/outlet-revenue-analysis`),
                type: "POST",
                data: {
                    date: data.date.format("MM/DD/YYYY")
                },
                success: function(response) {
                    dashboard.loading_up(func);
                    var subtitle = dashboard.subtitle({ data });

                    if (!response.hasOwnProperty("data")) {
                        dashboard.show_no_data({ id: func, data, subtitle });
                        return;
                    }

                    var series = [];

                    $.each(response.data.month.data, function(key, value) {
                        series.push({
                            name: key,
                            data: value
                        });
                    });

                    dashboard.line_chart({
                        categories: response.data.month.time,
                        series: series,
                        id: func,
                        title: data.title,
                        subtitle
                    });
                }
            });
        },
        "day-of-week-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            dashboard.loading_down(func);

            $.ajax({
                url: url("/report/day-of-week-guest-analysis"),
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from: data.from.format("DD-MM-YYYY"),
                    to: data.to.format("DD-MM-YYYY")
                },
                success: function(response) {
                    dashboard.loading_up(func);
                    var subtitle = dashboard.subtitle({ outlet, data });

                    if (!response.hasOwnProperty("data")) {
                        dashboard.show_no_data({
                            id: func,
                            outlet,
                            data,
                            subtitle
                        });
                        return;
                    }

                    $.each(response.data, function(i, point) {
                        point.name = point.dayname;
                        point.y = point[data.field];
                    });

                    dashboard.pie_chart({
                        data: response.data,
                        id: func,
                        title: data.title,
                        subtitle
                    });
                }
            });
        },
        "weekly-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            dashboard.loading_down(func);

            $.ajax({
                url: url("/report/weekly-guest-analysis"),
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from: data.from.format("DD-MM-YYYY"),
                    to: data.to.format("DD-MM-YYYY")
                },
                success: function(response) {
                    dashboard.loading_up(func);
                    var subtitle = dashboard.subtitle({ outlet, data });

                    if (!response.hasOwnProperty("data")) {
                        dashboard.show_no_data({
                            id: func,
                            outlet,
                            data,
                            subtitle
                        });
                        return;
                    }

                    var items = {};
                    var categories = [];

                    $.each(response.data[data.based_on], function(date, point) {
                        categories.push(moment(date).format("DD-MM-YYYY"));

                        $.each(point, function(field, value) {
                            if (!items.hasOwnProperty(field)) {
                                items[field] = { name: field, data: [] };
                            }

                            items[field].data.push(
                                parseFloat(value[data.field])
                            );
                        });
                    });

                    var series = [];
                    $.each(items, function(i, point) {
                        series.push(point);
                    });

                    dashboard.line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle
                    });
                }
            });
        },
        "monthly-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            dashboard.loading_down(func);

            $.ajax({
                url: url("/report/monthly-guest-analysis"),
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from_month: data.from.format("MM"),
                    to_month: data.to.format("MM"),
                    from_year: data.from.format("YYYY"),
                    to_year: data.to.format("YYYY")
                },
                success: function(response) {
                    dashboard.loading_up(func);
                    var subtitle = dashboard.subtitle({ outlet, data });

                    if (!response.hasOwnProperty("data")) {
                        dashboard.show_no_data({
                            id: func,
                            outlet,
                            data,
                            subtitle
                        });
                        return;
                    }

                    var items = {};
                    var categories = [];

                    $.each(response.data[data.based_on], function(date, point) {
                        categories.push(
                            `${date.substr(4)}-${date.substr(0, 4)}`
                        );

                        $.each(point, function(field, value) {
                            if (!items.hasOwnProperty(field)) {
                                items[field] = { name: field, data: [] };
                            }

                            items[field].data.push(
                                parseFloat(value[data.field])
                            );
                        });
                    });

                    var series = [];
                    $.each(items, function(i, point) {
                        series.push(point);
                    });

                    dashboard.line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle
                    });
                }
            });
        },
        "yearly-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            dashboard.loading_down(func);

            $.ajax({
                url: url("/report/yearly-guest-analysis"),
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from: data.from.format("YYYY"),
                    to: data.to.format("YYYY")
                },
                success: function(response) {
                    dashboard.loading_up(func);
                    var subtitle = dashboard.subtitle({ outlet, data });

                    if (!response.hasOwnProperty("data")) {
                        dashboard.show_no_data({
                            id: func,
                            outlet,
                            data,
                            subtitle
                        });
                        return;
                    }

                    var categories = [];
                    var items = {};

                    $.each(response.data, function(month, field) {
                        categories.push(month);
                        $.each(field[data.field], function(year, point) {
                            if (year != data.except) {
                                if (!items.hasOwnProperty(year)) {
                                    items[year] = { name: year, data: [] };
                                }
                                items[year].data.push(point);
                            }
                        });
                    });

                    var series = [];
                    $.each(items, function(i, point) {
                        series.push(point);
                    });

                    dashboard.line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle
                    });
                }
            });
        },

        pie_chart: function(data) {
            Highcharts.chart(data.id, {
                chart: {
                    type: "pie"
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: data.title
                },
                subtitle: {
                    text: data.subtitle
                },
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
                        data: data.data
                    }
                ]
            });
        },
        line_chart: function(data) {
            Highcharts.chart(data.id, {
                chart: {
                    type: "line"
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: data.title
                },
                subtitle: {
                    text: data.subtitle
                },
                xAxis: {
                    categories: data.categories
                },
                yAxis: {
                    title: {
                        text: data.hint
                    }
                },
                plotOptions: {
                    line: {
                        cursor: "pointer"
                    }
                },
                series: data.series
            });
        },
        show_no_data: function(params) {
            var no_data = $(`#${params.id}`).find(".no-data");
            no_data.find(".title").html(params.data.title);
            no_data.find(".subtitle").html(params.subtitle);
            no_data.slideDown("slow");
        },

        subtitle: function(params) {
            if (params.data.date != null) {
                date = `${params.data.date.format(params.data.date_format)}`;
            } else {
                date = `${params.data.from.format(
                    params.data.date_format
                )} - ${params.data.to.format(params.data.date_format)}`;
            }

            if (params.outlet != null) {
                subtitle = `${params.outlet.outletnm} (${date})`;
            } else {
                subtitle = `${date}`;
            }

            return subtitle;
        },

        loading_down: function(func) {
            $(`.${func}`).slideDown("slow");
            $(`#${func}`).slideUp("slow");
        },
        loading_up: function(func) {
            $(`.${func}`).slideUp("slow");
            $(`#${func}`).slideDown("slow");
        }
    }
});

$(document).ready(function() {
    dashboard.refresh_outlet();
    start = setInterval(function() {
        if (app.menu != null) {
            clearInterval(start);
            $("[vue-data]").slideDown("slow");
            $.each(app.menu, function(index, value) {
                path = value.url.split("/");
                item = path[path.length - 1];
                if (dashboard.chart.list.hasOwnProperty(item)) {
                    dashboard.chart.display.push({
                        title: value.name,
                        link: value.url,
                        id: item,
                        seq: dashboard.chart.list[item].seq
                    });
                    dashboard[item]();
                }
            });
        }
    }, 1000);
});
