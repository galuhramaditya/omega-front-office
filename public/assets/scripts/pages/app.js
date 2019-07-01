var app = new Vue({
    el: "#app",
    data: {
        user: {
            id: null,
            username: null,
            admin: null
        },
        menu: [
            {
                title: "Dashboard",
                icon: "home",
                link: "/"
            },
            {
                title: "Day of Week Guest Analysis",
                icon: "book",
                link: "/report/day-of-week-guest-analysis"
            },
            {
                title: "Monthly Guest Analysis",
                icon: "book",
                link: "/report/monthly-guest-analysis"
            },
            {
                title: "Weekly Guest Analysis",
                icon: "book",
                link: "/report/weekly-guest-analysis"
            }
        ]
    },
    computed: {
        token: function() {
            return localStorage.getItem("token");
        },
        path: function() {
            return window.location.pathname;
        }
    },
    methods: {
        refresh_user: function() {
            $.ajax({
                type: "post",
                url: "/user/current",
                data: {
                    token: app.token
                },
                success: function(response) {
                    app.user = response.data;
                },
                error: function() {
                    app.handle_logout();
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
            doc.document.write($(".on-print").html());
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
    app.refresh_user();
    $("[vue-data]").slideDown("slow");
});
