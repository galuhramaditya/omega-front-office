var page = new Vue({
    data: {
        pages: null
    },
    methods: {
        refresh_pages: function() {
            $.ajax({
                type: "get",
                url: url("/page/get"),
                data: {
                    token: app.token
                },
                success: function(response) {
                    page.pages = response.data;
                },
                error: function() {
                    page.refresh_pages();
                }
            });
        },
        handle_create: function() {
            var form = $("[form-action=create]");
            var name = form.find("input[name=name]").val();
            var link = form.find("input[name=url]").val();

            hideFormAlert();

            $.ajax({
                type: "post",
                url: url("/page/create"),
                data: {
                    token: app.token,
                    name: name,
                    url: link
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
                    var link = form.find("input[name=url]").val();

                    hideFormAlert();

                    $.ajax({
                        type: "patch",
                        url: url("/page/edit"),
                        data: {
                            token: app.token,
                            id: id,
                            name: name,
                            url: link
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
                        url: url("/page/delete"),
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
