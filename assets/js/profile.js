function getUserInfo(username) {
    $.ajax({
        url: "assets/phptools/profileTools.php",
        type: 'GET',
        data: {username: true},
        success: function(response) {
        JSON.parse(response);

        },
    });
}


$(document).ready(function () {
    $('#setting-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "assets/phptools/profileTools.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) { 
                console.log(response);  
                setTimeout(function () {
                    location.reload();
                });
            },
        });
    });

});