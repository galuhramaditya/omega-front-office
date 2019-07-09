var role = new Vue({
    data: {
        roles: null,
        pages: null
    },
    methods: {
        refresh_roles: function() {
            $.ajax({
                type: "get",
                url: "/role/get",
                data: {
                    token: app.token
                },
                success: function(response) {
                    role.roles = response.data;
                    role.refresh_pages();
                },
                error: function() {
                    role.refresh_roles();
                }
            });
        },
        refresh_pages: function() {
            $.ajax({
                type: "get",
                url: "/page/get",
                data: {
                    token: app.token
                },
                success: function(response) {
                    role.pages = response.data;
                    setTimeout(function() {
                        $(".selectpicker").selectpicker("refresh");
                    }, 0);
                }
            });
        },
        handle_create: function() {
            var form = $("[form-action=create]");
            var name = form.find("input[name=name]").val();
            var level = form.find("input[name=level]").val();
            var pages = form.find("select[name=pages]").val();

            hideFormAlert();

            $.ajax({
                type: "post",
                url: "/role/create",
                data: {
                    token: app.token,
                    name: name,
                    level: level,
                    pages: pages
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("create");
                    role.refresh_roles();
                },
                error: function(response) {
                    showFormAlert(form, response.responseJSON.data);
                }
            });
        },
        handle_edit: function(id, name) {
            refreshModal(`edit-${id}`, false);

            bootbox.confirm(`are you sure want to edit ${name}?`, function(
                result
            ) {
                if (result) {
                    var form = $(`[form-action=edit-${id}]`);
                    var name = form.find("input[name=name]").val();
                    var level = form.find("input[name=level]").val();
                    var pages = form.find("select[name=pages]").val();
                    console.log(pages);

                    hideFormAlert();

                    $.ajax({
                        type: "patch",
                        url: "/role/edit",
                        data: {
                            token: app.token,
                            id: id,
                            name: name,
                            level: level,
                            pages: pages
                        },
                        success: function(response) {
                            showAlert("success", response.message);
                            refreshModal(`edit-${id}`, false);
                            role.refresh_roles();
                            app.refresh_user();
                        },
                        error: function(response) {
                            openModal(`edit-${id}`, false);
                            showFormAlert(form, response.responseJSON.data);
                        }
                    });
                }
            });
        },
        handle_delete: function(id, name) {
            refreshModal(`delete-${id}`, false);

            bootbox.confirm(`are you sure want to delete ${name}?`, function(
                result
            ) {
                if (result) {
                    var form = $(`[form-action=delete-${id}]`);
                    var password = form.find("input[name=password]").val();

                    hideFormAlert();

                    $.ajax({
                        type: "delete",
                        url: "/role/delete",
                        data: {
                            token: app.token,
                            password: password,
                            id: id
                        },
                        success: function(response) {
                            showAlert("success", response.message);
                            refreshModal(`delete-${id}`);
                            role.refresh_roles();
                        },
                        error: function(response) {
                            openModal(`delete-${id}`, false);
                            showFormAlert(form, response.responseJSON.data);
                        }
                    });
                }
            });
        }
    }
});

$(document).ready(function() {
    role.refresh_roles();
});
