var page = new Vue({
    methods: {
        refresh_pages: function() {
            $.ajax({
                type: "get",
                url: "/page/get",
                data: {
                    token: app.token
                },
                success: function(response) {
                    app.container = response.data;
                }
            });
        },
        handle_create: function() {
            var form = $("[form-action=create]");
            var name = form.find("input[name=name]").val();
            var url = form.find("input[name=url]").val();

            hideFormAlert();

            $.ajax({
                type: "post",
                url: "/page/create",
                data: {
                    token: app.token,
                    name: name,
                    url: url
                },
                success: function(response) {
                    showAlert("success", response.message);
                    refreshModal("create");
                    page.refresh_pages();
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
                    var url = form.find("input[name=url]").val();

                    hideFormAlert();

                    $.ajax({
                        type: "patch",
                        url: "/page/edit",
                        data: {
                            token: app.token,
                            id: id,
                            name: name,
                            url: url
                        },
                        success: function(response) {
                            showAlert("success", response.message);
                            refreshModal(`edit-${id}`, false);
                            page.refresh_pages();
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
                        url: "/page/delete",
                        data: {
                            token: app.token,
                            password: password,
                            id: id
                        },
                        success: function(response) {
                            showAlert("success", response.message);
                            refreshModal(`delete-${id}`);
                            page.refresh_pages();
                            app.refresh_user();
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
    page.refresh_pages();
});
