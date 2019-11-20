(function ($) {


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                console.log(reader);
                var extension = input.files[0].name.split('.').pop().toLowerCase();
                if (extension == 'jpg' || extension == 'png' || extension == 'jpeg' || extension == 'gif') {
                    $('#user-photo').attr('src', e.target.result);
                    $('.user-avatar').removeClass('d-none');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".input-user-photo").change(function () {
        readURL(this);
        $("#photo-error").remove();
    });

    $(".delete-photo").click(function (e) {
        e.preventDefault();
        $('#user-photo').attr('src', '');
        $('.input-user-photo').val('');
        $('.user-avatar').addClass('d-none');
    });

})(jQuery);