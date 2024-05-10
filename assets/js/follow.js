$(document).ready(function() {  
    $('#follow').click(function() {
        var profileId = document.body.dataset.profileId;
        var userId = document.body.dataset.userId;
        $.ajax({
        url: 'assets/phptools/followManager.php',
        type: 'POST',
        data: { userId : userId, 
                targetId : profileId,
                follow_unfollow : true},
        success: function(response) {
            console.log(response);
            if (response == 'Follow') {
            $('#follow').attr('data-follow', 'follow');
            $('#follow').text('Unfollow');
            } else if (response == 'Unfollow') {
            $('#follow').attr('data-follow', 'follow');
            $('#follow').text('Follow');
            }
        }
        });
    });
});
