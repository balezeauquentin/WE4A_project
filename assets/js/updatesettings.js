$(document).ready(function() {
    $('#setting-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "assets/phptools/updatesettings.php",
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) { 
                if (response.error) {
                    $('#error-message').text(response.message);
                } else if (response.success){
                    $('#success-message').text(response.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            },
        });
    });
});

function getSettingsInfo($userId) {
    $.ajax({
        url: "assets/phptools/updatesettings.php",
        type: 'GET',
        data: {
            getSettingsInfo: true,
            userId: $userId
        },
        success: function(response) {
                var userInfo = JSON.parse(response);;
                // Update form fields with user information
                $('#email').val(userInfo.email);
                $('#address').val(userInfo.address);
                $('#city').val(userInfo.city);
                $('#zip_code').val(userInfo.zip_code);
                $('#country').val(userInfo.country);
            },
    });
}

$(document).ready(function () {
    var userId = document.body.dataset.settingsId;
    getSettingsInfo(userId);
});