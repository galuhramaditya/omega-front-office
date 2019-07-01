var app = new Vue({
    el: "#login",
    methods: {
        handleLogin: function() {
            var form = $("[form-action=login]");
            var username = form.find("input[name=username]").val();
            var password = form.find("input[name=password]").val();
            hideFormAlert();

            $.ajax({
                type: "POST",
                url: "/user/login",
                data: {
                    username: username,
                    password: password
                },
                success: function(response) {
                    showAlert("success", response.message);
                    localStorage.setItem("token", response.data.token);
                    window.location = "/";
                },
                error: function(response) {
                    showAlert("error", response.responseJSON.message);
                    showFormAlert(form, response.responseJSON.data);
                }
            });
        }
    }
});

jQuery(document).ready(function() {
    if (localStorage.hasOwnProperty("token")) {
        window.location = "/";
    }
    $("input[name=username]").focus();
});
