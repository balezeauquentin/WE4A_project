

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