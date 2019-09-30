var dashboard = new Vue({
    methods: {
        handle_self_edit: function() {
            var form = $("[form-action=self-edit]");
            var username = form.find("input[name=username]").val();

            hideFormAlert();

            $.ajax({
                type: "patch",
                url: url("/user/self-edit"),
                data: {
                    token: app.token,
                    username: username
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("self-edit", false);
                    bootbox.alert(
                        `${response.message}! we will logout immediatelely, please login again`,
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
                url: url("/user/self-edit/change-password"),
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
                        `${response.message}! we will logout immediatelely, please login again`,
                        function() {
                            app.handle_logout();
                        }
                    );
                },
                error: function(response) {
                    showFormAlert(form, response.responseJSON.data);
                }
            });
        }
    }
});
