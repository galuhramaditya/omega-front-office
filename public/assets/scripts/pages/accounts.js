var account = new Vue({
    data: {
        users: null,
        roles: null
    },
    methods: {
        refresh_users: function() {
            $.ajax({
                type: "get",
                url: url("/user/accounts/get"),
                data: {
                    token: app.token
                },
                success: function(response) {
                    account.users = response.data;
                    account.refresh_roles();
                },
                error: function() {
                    account.refresh_users();
                }
            });
        },
        refresh_roles: function() {
            $.ajax({
                type: "get",
                url: url("/role/get"),
                data: {
                    token: app.token
                },
                success: function(response) {
                    account.roles = response.data;
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
            var role = form.find("select[name=role]").val();

            hideFormAlert();

            $.ajax({
                type: "post",
                url: url("/user/create"),
                data: {
                    token: app.token,
                    username: username,
                    password: password,
                    password_confirmation: password_confirmation,
                    role: role
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
                    var role = form.find("select[name=role]").val();

                    hideFormAlert();

                    $.ajax({
                        type: "patch",
                        url: url("/user/edit"),
                        data: {
                            token: app.token,
                            role: role,
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
                            url: url("/user/delete"),
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
