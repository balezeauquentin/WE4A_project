function getUserInfo(username) {
    $.ajax({
        url: "assets/phptools/profileTools.php",
        type: 'GET',
        data: {username: true},
        success: function(response) {
            var user = JSON.parse(response);
                            var element = document.querySelector('#posts-container');
                insertPost(rep, element);
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
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    $('#follow').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: "assets/phptools/followTools.php",
            type: 'POST',
            data: { follow: true,             
                userId: profileId 
            },
            success: function(response) { 
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});