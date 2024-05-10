$(document).ready(function() {
    var selectedOption = "Usernames"; // Set Usernames as default value because fuck

    $('.form-select').change(function() {
        selectedOption = $(this).val(); // Store the selected option in the variable
    });

    // Later in your code, you can use the selectedOption variable in another AJAX request
    $('#search-btn').click(function() {
        var searchText = $('#text-input').val(); // Get the text from the input field

        if (searchText.trim().length < 3) {
            var container = $('#search-container');

            // Clear the container
            container.empty();
            container.append("Please write at least 3 characters.");
            return;
        }

        $.ajax({
            url: 'assets/phptools/search_handler.php',
            type: 'POST',
            data: {
                searchText: searchText,
                searchType: selectedOption
            },
            success: function(response) {
                response = JSON.parse(response);
                if (selectedOption == "Usernames")
                displayUsers(response);
                else if (selectedOption == "Posts")
                displayPosts(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error when connecting to the server.");
            }
        });
    });
});

function displayUsers(data) {
    var container = $('#search-container');

    // Clear the container
    container.empty();

    if (data.length === 0) {
        container.append("No users found.");
        return;
    }
    // Iterate over the data
    data.forEach(function(user) {
        // Cursed but its fine
        container.append("<a class='d-flex align-items-center justify-content-around text-decoration-none link-dark' href='./profile.php?username="
        + user.username + "\'><div class=' me-4 rounded-1' style='width: 40px; height: 40px; background: url(\""
        + user.profile_picture_path + "\"); background-size: cover;\'></div><div>"
        + user.username + "</div></a>");
    });
}

function displayPosts(data) {
    var container = $('#search-container');

    // Clear the container
    container.empty();

    if (data.length === 0) {
        container.append("No posts found.");
        return;
    }
    // Iterate over the data
    data.forEach(function(post) {
        // Cursed but its fine
        container.append("<a class='d-flex align-items-left justify-content-left text-decoration-none link-dark' href='./posts.php?="
        + post.id + "'><div class=' me-4 rounded-1' style='width: 40px; height: 40px; background: url(\""
        + post.profile_picture_path + "\"); background-size: cover;\'></div><div><p>"
        + post.username + "<br>"
        + post.content + "</p></div></a>");
    });
}