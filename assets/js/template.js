/* Login */
$('#formLoginId').submit(function (e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: '/WE4A_PROJECT/assets/phptools/login.php',
        data: formData,
        success: function (response) {
            if (response.error) {
                $('#error-message').text(response.message);
            }
            setTimeout(function () {
                location.reload();
            }, 1000);
        }
    });
});

/* register */
$('#formRegisterId').submit(function (e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: '/WE4A_PROJECT/assets/phptools/register.php',
        data: formData,
        success: function (response) {
            if (response.error) {
                $('#error-message-r').text(response.message);
            }
            setTimeout(function () {
                location.reload();
            }, 1000);
        }
    });
});