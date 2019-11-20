$(function () {
    $(".validate-form").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                min: 6,
            },
            username: {
                required: true,
                minlength: 6,
            },
            confirm_password: {
                required: true,
                equalTo: "#password",
            },
        }
    });
});