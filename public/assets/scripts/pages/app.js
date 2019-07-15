var app = new Vue({
    el: "#app",
    data: {
        user: null,
        menu: null,
        token: null
    },
    computed: {
        path: function() {
            return window.location.pathname;
        }
    },
    watch: {
        token: function() {
            app.refresh_user();
        }
    },
    methods: {
        refresh_token: function() {
            app.token = localStorage.getItem("token");
        },
        refresh_user: function() {
            app.menu = null;
            $.ajax({
                type: "post",
                url: "/user/current",
                data: {
                    token: app.token
                },
                success: function(response) {
                    app.user = response.data;

                    if (response.data.role != null) {
                        app.menu = response.data.role.pages;
                    }

                    $("[vue-data]").slideDown("slow");
                    $("#on-print").slideUp("slow");
                    $(".loader").fadeOut("slow");
                },
                error: function() {
                    app.refresh_user();
                }
            });
        },
        handle_logout: function() {
            localStorage.removeItem("token");
            sessionStorage.removeItem("document");
            window.location = "/login";
        },
        print: function(title) {
            var doc = window.open();
            doc.document.write("<html><head>");
            doc.document.write(
                `<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                <link href="/assets/css/print.css" rel="stylesheet" type="text/css" />`
            );
            doc.document.write("</head><body>");
            doc.document.write($("#on-print").html());
            doc.document.write("</body></html>");
            doc.document.title = title;
            setTimeout(function() {
                doc.print();
                doc.close();
            }, 0);
        }
    }
});

$(document).ready(function() {
    app.refresh_token();

    Highcharts.setOptions({
        lang: {
            numericSymbols: ["rb", "jt", "m", "t"]
        }
    });
});
