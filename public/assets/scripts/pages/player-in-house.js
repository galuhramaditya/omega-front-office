var report = new Vue({
    data: {
        outlet: null,
        total: null,
        reports: null
    },
    methods: {
        summary_output: function(index, field, key) {
            var data = report.reports.summary.data[index][field][key];
            setTimeout(function() {
                var tag_total = $("tr#total");

                if (_.size(report.total) == 0) {
                    tag_total.find("td").remove();
                }

                if (tag_total.find("td").length == 0) {
                    tag_total.append(
                        "<td colspan=2 class='text-center'>Total</td>"
                    );
                }

                if (!report.total.hasOwnProperty(`${field}-${key}`)) {
                    report.total[`${field}-${key}`] = data;
                    tag_total.append(`<td data=${field}-${key}>${data}</td>`);
                } else {
                    report.total[`${field}-${key}`] += data;
                    var total = report.total[`${field}-${key}`];

                    tag_total.find(`td[data=${field}-${key}]`).html(
                        total.toLocaleString(undefined, {
                            maximumFractionDigits: 2
                        })
                    );
                }
            }, 0);
            return data.toLocaleString(undefined, { maximumFractionDigits: 2 });
        },
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
            $(".loader").slideDown("slow");

            var outlet = $("select[name=outlet] option:selected").val();
            var date = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("mm/dd/yyyy");

            $.ajax({
                url: url("/report/player-in-house"),
                type: "POST",
                data: {
                    outlet: outlet,
                    date: date,
                    username: app.user.username
                },
                success: function(response) {
                    $(".loader").slideUp("slow");

                    if (response.hasOwnProperty("data")) {
                        report.total = {};
                        report.reports = response.data;

                        $("#on-print").slideDown("slow", function() {
                            scrollTo($("#on-print"));
                        });
                    } else {
                        bootbox.alert(`data doesn't exist on ${date}`);
                    }
                }
            });
        },
        print: function() {
            var outlet = $("select[name=outlet] option:selected").attr("name");
            var date = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("dd/mm/yyyy");

            app.print(`${outlet} (${date})`);
        }
    }
});

$(document).ready(function() {
    report.refresh_outlet();
    $("input[name=date]")
        .datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            endDate: "0d",
            orientation: "bottom",
            todayHighlight: true
        })
        .datepicker("setDate", moment().format("DD/MM/YYYY"));

    start = setInterval(function() {
        if (report.outlet != null) {
            clearInterval(start);
            report.refresh_report();
        }
    }, 1000);
});
