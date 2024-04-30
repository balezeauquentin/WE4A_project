$(document).ready(function() {
    var selectedOption = "Usernames"; // Set Usernames as default value because fuck

    $('.form-select').change(function() {
        selectedOption = $(this).val(); // Store the selected option in the variable
    });

    // Later in your code, you can use the selectedOption variable in another AJAX request
    $('#search-btn').click(function() {
        var searchText = $('#text-input').val(); // Get the text from the input field
        console.log(searchText);

        $.ajax({
            url: 'assets/phptools/search_handler.php',
            type: 'POST',
            data: {
                searchText: searchText,
                searchType: selectedOption
            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Erreur lors de la connexion avec le serveur.");
            }
        });
    });
});