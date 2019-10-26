var report = new Vue({
    data: {
        reports: null,
        total_days: 31
    },
    methods: {
        refresh_report: function() {
            $("#on-print").slideUp("slow");
            $(".loader").slideDown("slow");

            var type = $("select[name=type] option:selected").val();
            var date = $("input[name=date]").data("datepicker");
            var month = date.getFormattedDate("mm");
            var year = date.getFormattedDate("yyyy");
            report.total_days = moment(
                date.getFormattedDate("mm/yyyy"),
                "MM/YYYY"
            ).daysInMonth();

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
