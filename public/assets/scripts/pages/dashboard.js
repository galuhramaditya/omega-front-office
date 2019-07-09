var dashboard = new Vue({
    data: {
        outlet: null,
        chart: {
            display: [],
            list: {
                "day-of-week-guest-analysis": {
                    title: "Total Venue",
                    field: "amttotal",
                    from: moment().startOf("month"),
                    to: moment()
                },
                "weekly-guest-analysis": {
                    title: "Amount Player by Status",
                    field: "ttlamt2",
                    hint: "amount",
                    based_on: "player_status",
                    by: "amount",
                    from: moment().subtract(6, "days"),
                    to: moment()
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
                    to: moment()
                },
                "yearly-guest-analysis": {
                    title: "Income from Player",
                    field: "amount",
                    hint: "Rp. 1,000",
                    except: "pers",
                    from: moment().subtract(3, "year"),
                    to: moment()
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
        handle_self_edit: function() {
            var form = $("[form-action=self-edit]");
            var username = form.find("input[name=username]").val();

            hideFormAlert();

            $.ajax({
                type: "patch",
                url: "/user/self-edit",
                data: {
                    token: app.token,
                    username: username
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("self-edit", false);
                    bootbox.alert(
                        `${
                            response.message
                        }! we will logout immediatelely, please login again`,
                        function() {
                            app.handle_logout();
                        }
                    );
                },
                error: function(response) {
                    showFormAlert(form, response.responseJSON.data);
                }
            });
        },
        handle_change_self_password: function() {
            var form = $("[form-action=change-self-password]");
            var password = form.find("input[name=password]").val();
            var new_password = form.find("input[name=new_password]").val();
            var new_password_confirmation = form
                .find("input[name=new_password_confirmation]")
                .val();

            hideFormAlert();

            $.ajax({
                type: "patch",
                url: "/user/self-edit/change-password",
                data: {
                    token: app.token,
                    password: password,
                    new_password: new_password,
                    new_password_confirmation: new_password_confirmation
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("change-self-password", false);
                    bootbox.alert(
                        `${
                            response.message
                        }! we will logout immediatelely, please login again`,
                        function() {
                            app.handle_logout();
                        }
                    );
                },
                error: function(response) {
                    showFormAlert(form, response.responseJSON.data);
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
                    if (!response.hasOwnProperty("data")) {
                        $(`[data=${func}]`).slideUp("slow");
                        return;
                    }

                    loading_up(func);

                    $.each(response.data, function(i, point) {
                        point.name = point.dayname;
                        point.y = point[data.field];
                    });

                    pie_chart({
                        data: response.data,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle: `${outlet.outletnm} (${data.from.format(
                            "DD/MM/YYYY"
                        )} - ${data.to.format("DD/MM/YYYY")})`
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
                    if (!response.hasOwnProperty("data")) {
                        $(`[data=${func}]`).slideUp("slow");
                        return;
                    }

                    loading_up(func);

                    var items = response.data[data.based_on];
                    var obj = {};
                    var categories = [];

                    $.each(items, function(date, point) {
                        categories.push(moment(date).format("DD-MM-YYYY"));

                        $.each(point, function(field, value) {
                            if (!obj.hasOwnProperty(field)) {
                                obj[field] = { name: field, data: [] };
                            }

                            obj[field].data.push(parseFloat(value[data.field]));
                        });
                    });

                    var series = [];
                    $.each(obj, function(i, point) {
                        series.push(point);
                    });

                    line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle: `${outlet.outletnm} (${data.from.format(
                            "DD/MM/YYYY"
                        )} - ${data.to.format("DD/MM/YYYY")})`
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
                    if (!response.hasOwnProperty("data")) {
                        $(`[data=${func}]`).slideUp("slow");
                        return;
                    }

                    loading_up(func);

                    var items = response.data[data.based_on];
                    var obj = {};
                    var categories = [];
                    $.each(items, function(date, point) {
                        categories.push(
                            `${date.substr(4)}-${date.substr(0, 4)}`
                        );

                        $.each(point, function(field, value) {
                            if (!obj.hasOwnProperty(field)) {
                                obj[field] = { name: field, data: [] };
                            }

                            obj[field].data.push(parseFloat(value[data.field]));
                        });
                    });

                    var series = [];
                    $.each(obj, function(i, point) {
                        series.push(point);
                    });

                    line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle: `${outlet.outletnm} (${data.from.format(
                            "MM/YYYY"
                        )} - ${data.to.format("MM/YYYY")})`
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
                    if (!response.hasOwnProperty("data")) {
                        $(`[data=${func}]`).slideUp("slow");
                        return;
                    }

                    loading_up(func);

                    var categories = [];
                    var items = {};
                    var series = [];

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

                    $.each(items, function(i, point) {
                        series.push(point);
                    });

                    line_chart({
                        categories: categories,
                        series: series,
                        id: func,
                        hint: data.hint,
                        title: data.title,
                        subtitle: `${outlet.outletnm} (${data.from.format(
                            "YYYY"
                        )} - ${data.to.format("YYYY")})`
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

var loading_down = function(func) {
    $(`.${func}`).slideDown("slow");
    $(`#${func}`).slideUp("slow");
};

var loading_up = function(func) {
    $(`.${func}`).slideUp("slow");
    $(`#${func}`).slideDown("slow");
};
