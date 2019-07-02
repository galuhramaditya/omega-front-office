var account = new Vue({
    methods: {
        refresh_users: function() {
            $.ajax({
                type: "get",
                url: "/user/account/get",
                success: function(response) {
                    app.container = response.data;
                }
            });
        },
        handle_self_edit: function() {
            var form = $("[form-action=self-edit]");
            var username = form.find("input[name=username]").val();
            hideFormAlert();

            $.ajax({
                type: "patch",
                url: "/user/self-edit",
                data: {
                    token: app.token,
                    username: username
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("self-edit", false);
                    setTimeout(function() {
                        app.handle_logout();
                    }, 2000);
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
                url: "/user/self-edit/change-password",
                data: {
                    token: app.token,
                    password: password,
                    new_password: new_password,
                    new_password_confirmation: new_password_confirmation
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("change-self-password", false);
                    setTimeout(function() {
                        app.handle_logout();
                    }, 2000);
                },
                error: function(response) {
                    showFormAlert(form, response.responseJSON.data);
                }
            });
        },
        handle_create: function() {
            var form = $("[form-action=create]");
            var username = form.find("input[name=username]").val();
            var password = form.find("input[name=password]").val();
            var password_confirmation = form
                .find("input[name=password_confirmation]")
                .val();
            var permission = form.find("input[name=permission]:checked").val();
            hideFormAlert();

            $.ajax({
                type: "post",
                url: "/user/create",
                data: {
                    token: app.token,
                    username: username,
                    password: password,
                    password_confirmation: password_confirmation,
                    permission: permission
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("create");
                    account.refresh_users();
                },
                error: function(response) {
                    showFormAlert(form, response.responseJSON.data);
                }
            });
        },
        handle_edit: function(id, username) {
            refreshModal(`edit-${id}`, false);
            bootbox.confirm(`are you sure want to edit ${username}?`, function(
                result
            ) {
                if (result) {
                    var form = $(`[form-action=edit-${id}]`);
                    var permission = form
                        .find("input[name=permission]:checked")
                        .val();
                    hideFormAlert();

                    $.ajax({
                        type: "patch",
                        url: "/user/edit",
                        data: {
                            token: app.token,
                            permission: permission,
                            id: id
                        },
                        success: function(response) {
                            showAlert("success", response.message);
                            refreshModal(`edit-${id}`, false);
                            account.refresh_users();
                        },
                        error: function(response) {
                            openModal(`edit-${id}`, false);
                            showFormAlert(form, response.responseJSON.data);
                        }
                    });
                }
            });
        },
        handle_delete: function(id, username) {
            refreshModal(`delete-${id}`, false);
            bootbox.confirm(
                `are you sure want to delete ${username}?`,
                function(result) {
                    if (result) {
                        var form = $(`[form-action=delete-${id}]`);
                        var password = form.find("input[name=password]").val();
                        hideFormAlert();

                        $.ajax({
                            type: "delete",
                            url: "/user/delete",
                            data: {
                                token: app.token,
                                password: password,
                                id: id
                            },
                            success: function(response) {
                                showAlert("success", response.message);
                                refreshModal(`delete-${id}`);
                                account.refresh_users();
                            },
                            error: function(response) {
                                openModal(`delete-${id}`, false);
                                showFormAlert(form, response.responseJSON.data);
                            }
                        });
                    }
                }
            );
        }
    }
});

$(document).ready(function() {
    account.refresh_users();
});
