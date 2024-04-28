    /* Login */
    $('#formLoginId').submit(function (e) {

        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'php_tool/login.php',
            data: formData,
            success: function (response) {
                if (response.error) {
                    $('#error-message').text(response.message);
                } else {
                    $('#modalLogin').modal('hide');
                    var loginToast = new bootstrap.Toast(document.getElementById('loginToast'));
                    loginToast.show();
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
                document.getElementById('formLoginId').reset();
            }
        });
    });