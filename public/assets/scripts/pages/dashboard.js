var dashboard = new Vue({
    data: {
        outlet: null,
        chart: {
            display: [],
            list: {
                "day-of-week-guest-analysis": {
                    title: "Total Revenue",
                    field: "amttotal",
                    from: moment().startOf("month"),
                    to: moment(),
                    date_format: "DD/MM/YYYY"
                },
                "weekly-guest-analysis": {
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
                    title: "Income from Player",
                    field: "amount",
                    hint: "Rp. 1,000",
                    except: "pers",
                    from: moment().subtract(3, "year"),
                    to: moment(),
                    date_format: "YYYY"
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
                    dashboard.outlet = response.data;
                }
            });
        },
        "day-of-week-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            loading_down(func);

            $.ajax({
                url: "/report/day-of-week-guest-analysis",
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from: data.from.format("DD-MM-YYYY"),
                    to: data.to.format("DD-MM-YYYY")
                },
                success: function(response) {
                    loading_up(func);

                    if (!response.hasOwnProperty("data")) {
                        show_no_data(func, outlet, data);
                        return;
                    }

                    $.each(response.data, function(i, point) {
                        point.name = point.dayname;
                        point.y = point[data.field];
                    });

                    pie_chart({
                        data: response.data,
                        id: func,
                        title: data.title,
                        subtitle: subtitle(outlet, data)
                    });
                }
            });
        },
        "weekly-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            loading_down(func);

            $.ajax({
                url: "/report/weekly-guest-analysis",
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from: data.from.format("DD-MM-YYYY"),
                    to: data.to.format("DD-MM-YYYY")
                },
                success: function(response) {
                    loading_up(func);

                    if (!response.hasOwnProperty("data")) {
                        show_no_data(func, outlet, data);
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

                    line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle: subtitle(outlet, data)
                    });
                }
            });
        },
        "monthly-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            loading_down(func);

            $.ajax({
                url: "/report/monthly-guest-analysis",
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from_month: data.from.format("MM"),
                    to_month: data.to.format("MM"),
                    from_year: data.from.format("YYYY"),
                    to_year: data.to.format("YYYY")
                },
                success: function(response) {
                    loading_up(func);

                    if (!response.hasOwnProperty("data")) {
                        show_no_data(func, outlet, data);
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

                    line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle: subtitle(outlet, data)
                    });
                }
            });
        },
        "yearly-guest-analysis": function() {
            var func = arguments.callee.name;
            var data = dashboard.chart.list[func];
            var outlet = dashboard.outlet[0];

            loading_down(func);

            $.ajax({
                url: "/report/yearly-guest-analysis",
                type: "POST",
                data: {
                    outlet: outlet.outletcd,
                    from: data.from.format("YYYY"),
                    to: data.to.format("YYYY")
                },
                success: function(response) {
                    loading_up(func);

                    if (!response.hasOwnProperty("data")) {
                        show_no_data(func, outlet, data);
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

                    line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle: subtitle(outlet, data)
                    });
                }
            });
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
                        id: item
                    });
                    dashboard[item]();
                }
            });
        }
    }, 1000);
});

var pie_chart = function(data) {
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
                    format: "<b>{point.name}</b>: {point.percentage:.2f}%"
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
};

var line_chart = function(data) {
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
};

var show_no_data = function(id, outlet, data) {
    var no_data = $(`#${id}`).find(".no-data");
    no_data.find(".title").html(data.title);
    no_data.find(".subtitle").html(subtitle(outlet, data));
    no_data.slideDown("slow");
};

var subtitle = function(outlet, data) {
    return `${outlet.outletnm} (${data.from.format(
        data.date_format
    )} - ${data.to.format(data.date_format)})`;
};

var loading_down = function(func) {
    $(`.${func}`).slideDown("slow");
    $(`#${func}`).slideUp("slow");
};

var loading_up = function(func) {
    $(`.${func}`).slideUp("slow");
    $(`#${func}`).slideDown("slow");
};
