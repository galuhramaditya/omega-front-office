var report = new Vue({
    data: {
        outlet: null,
        total: null,
        reports: null
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
            $(".on-print").slideUp("slow");
            $(".loader").slideDown("slow");
            var outlet = $("select[name=outlet] option:selected").val();
            var date = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("mm/dd/yyyy");

            $.ajax({
                url: "/report/player-in-house",
                type: "POST",
                data: {
                    outlet: outlet,
                    date: date,
                    username: app.user.username
                },
                success: function(response) {
                    $(".loader").slideUp("slow");
                    if (response.hasOwnProperty("data")) {
                        report.reports = response.data;

                        $(".on-print").slideDown("slow", function() {
                            scrollTo($(".on-print"));
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
});
