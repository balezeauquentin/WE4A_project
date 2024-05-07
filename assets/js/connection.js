/* Login */
$('#formLoginId').submit(function (e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: '/WE4A_project/assets/phptools/login.php',
        data: formData,
        success: function (response) {
            if (response.error) {
                $('#error-message').text(response.message);
            } else if (response.success){
                $('#success-message').text(response.message);
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
        url: '/WE4A_project/assets/phptools/register.php',
        data: formData,
        success: function (response) {
            if (response.error) {
                $('#error-message-r').text(response.message);
            } else if (response.success){
                $('#success-message-r').text(response.message);
            }
            setTimeout(function () {
                window.location.href = "/WE4A_project/index.php"
                location.reload();
            }, 1000);
        }
    });
});

/* Login */
$('#logout-button').click(function (e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: '/WE4A_project/assets/phptools/logout.php',
        data: formData,
        success: function (response) {
            setTimeout(function () {
                window.location.href = "/WE4A_project/index.php"
            });
        }
    });
});