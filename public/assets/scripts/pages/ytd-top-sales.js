var report = new Vue({
    data: {
        outlet: ["GOLF", "RESTO/F&B", "PROSHOP", "DRIVING", "OTHER POS"],
        reports: null
    },
    methods: {
        refresh_report: function() {
            $("#on-print").slideUp("slow");
            $(".loader").slideDown("slow");

            var outlet = $("select[name=outlet] option:selected").val();
            var type = $("select[name=type] option:selected").val();
            var date = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("mm/dd/yyyy");

            $.ajax({
                url: url(`/report/ytd-top-sales`),
                type: "POST",
                data: {
                    outlet: outlet,
                    date: date,
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
