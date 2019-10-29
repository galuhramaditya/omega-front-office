var report = new Vue({
    data: {
        reports: null,
        month: null
    },
    methods: {
        refresh_report: function() {
            $("#on-print").slideUp("slow");
            $(".loader").slideDown("slow");

            var type = $("select[name=type] option:selected").val();
            var date = $("input[name=date]").data("datepicker");
            var month = date.getFormattedDate("mm");
            var year = date.getFormattedDate("yyyy");
            report.month = moment(date.getFormattedDate("mm/yyyy"), "MM/YYYY");

            $.ajax({
                url: url(`/report/fb-top-sales`),
                type: "POST",
                data: {
                    month: month,
                    year: year,
                    type: type
                },
                success: function(response) {
                    $(".loader").slideUp("slow");

                    if (response.hasOwnProperty("data")) {
                        report.reports = response.data;
                        report.table("fb-table");

                        $("#on-print").slideDown("slow", function() {
                            scrollTo($("#on-print"));
                        });
                    } else {
                        bootbox.alert(
                            `data doesn't exist on ${date.getFormattedDate(
                                "mm/yyyy"
                            )}`
                        );
                    }
                }
            });
        },

        table(id) {
            const thead = $(`#${id}`);
            thead.html("");
            const reports = report.reports;
            const days = report.month.daysInMonth();

            for (var key in reports) {
                var reportf = reports[key];
                thead.append(
                    `<tr><td colspan="${days +
                        2}" class="bold">${key}</td></tr>`
                );

                for (var type in reportf) {
                    var datas = reportf[type];
                    thead.append(
                        `<tr><td colspan="${days +
                            2}" class="bold" style="padding-left: 40px"><u>${type}</u></td></tr>`
                    );

                    for (var desc in datas) {
                        var data = datas[desc];
                        var tr = `<tr><td style="padding-left: 40px">${desc}</td>`;

                        for (var date = 1; date <= days; date++) {
                            tr += `<td class="text-right">${
                                data.data[date] != null
                                    ? parseFloat(
                                          data.data[date]
                                      ).toLocaleString(undefined, {
                                          maximumFractionDigits: 2
                                      })
                                    : 0
                            }</td>`;
                        }

                        tr += `<td class="text-right">${parseFloat(
                            data.total
                        ).toLocaleString(undefined, {
                            maximumFractionDigits: 2
                        })}</td></tr>`;

                        thead.append(tr);
                    }
                }
            }
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
            format: "mm/yyyy",
            minViewMode: "months",
            autoclose: true,
            endDate: "0d",
            orientation: "bottom",
            todayHighlight: true
        })
        .datepicker("setDate", moment().format("MM/YYYY"));

    report.refresh_report();
});
