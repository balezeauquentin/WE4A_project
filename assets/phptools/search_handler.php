<?php
if (isset($_POST['searchText']) && isset($_POST['searchType'])) {
    $searchText = $_POST['searchText'];
    $searchType = $_POST['searchType'];

    // Perform the search based on $searchType
    // This is a placeholder - replace it with your actual search code
    $results = performSearch($searchText, $searchType);

    // Send the results back to the client
    echo json_encode($results);
}

function performSearch($searchText, $searchType) {
    // This is a placeholder function - replace it with your actual search code
    // For example, you might query a database or an API here

    if ($searchType === 'Usernames') {
        return ['user1', $searchText, 'user3'];
    } else if ($searchType === 'Posts') {
        return ['post1', 'post2', 'post3'];
    } else {
        return [];
    }
}