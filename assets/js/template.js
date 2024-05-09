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
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }

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
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (response.test){
                $('#success-message-r').text(response.message);
            }

        }
    });
});

/* Logout */
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

$(document).ready(function () {
    var userId = document.body.dataset.userId;
    if (!userId) return;
    setInterval(function () {
        console.log('Checking for new notifications...');
        $.ajax({
            url: 'assets/phptools/notificationManager.php',
            method: 'GET',
            data: {
                getUnreadNotifications: true,
                userId: userId
            },
            success: function (response) {
                // Assuming the server returns the number of new notifications
                var newNotifications = JSON.parse(response);
                console.log(newNotifications);
                if (newNotifications > 0) {
                    // Update the notifications badge
                    $('#notification-badge').text(newNotifications);
                }
            },
        });
    }, 10000); 
});

document.getElementById('showpassword-r').addEventListener('change', function () {
    var passwordField = document.getElementById('password-r');
    var passwordFieldRepeat = document.getElementById('password-r-repeat');

    if (this.checked) {
        // If the checkbox is checked, set the type to "text" to show the password
        passwordField.type = 'text';
        passwordFieldRepeat.type = 'text';
    } else {
        // If the checkbox is not checked, set the type back to "password" to hide the password
        passwordField.type = 'password';
        passwordFieldRepeat.type = 'password';
    }
});

document.getElementById('showpassword-l').addEventListener('change', function () {
    var passwordField = document.getElementById('password-l');

    if (this.checked) {
        // If the checkbox is checked, set the type to "text" to show the password
        passwordField.type = 'text';
        passwordFieldRepeat.type = 'text';
    } else {
        // If the checkbox is not checked, set the type back to "password" to hide the password
        passwordField.type = 'password';
        passwordFieldRepeat.type = 'password';
    }
});