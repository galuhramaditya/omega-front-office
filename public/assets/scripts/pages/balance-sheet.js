var report = new Vue({
    data: {
        company: null,
        total: null,
        reports: null
    },
    methods: {
        refresh_company: function() {
            $.ajax({
                type: "get",
                url: "/company/get",
                success: function(response) {
                    report.company = response.data;
                }
            });
        },
        refresh_report: function() {
            $(".on-print").slideUp("slow");
            $(".loader").slideDown("slow");

            var company = $("select[name=company] option:selected").val();
            var month = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("mm");
            var year = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("yyyy");

            $.ajax({
                url: "/report/balance-sheet",
                type: "POST",
                data: {
                    company: company,
                    month: month,
                    year: year
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
            var company = $("select[name=company] option:selected").val();
            var date = $("input[name=date]")
                .data("datepicker")
                .getFormattedDate("dd/mm/yyyy");

            app.print(`${company} (${date})`);
        }
    }
});

$(document).ready(function() {
    report.refresh_company();
    $("input[name=date]")
        .datepicker({
            format: "mm/yyyy",
            minViewMode: "months",
            autoclose: true,
            endDate: "0d",
            orientation: "bottom",
            todayHighlight: true
        })
        .datepicker("setDate", moment().format("DD/MM/YYYY"));
});
