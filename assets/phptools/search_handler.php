<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';

if (isset($_POST['searchText']) && isset($_POST['searchType'])) {
    $searchText = $_POST['searchText'];
    $searchType = $_POST['searchType'];

    // Perform the search based on $searchType
    $results = performSearch($searchText, $searchType);

    // Send the results back to the client
    echo json_encode($results);
}


function searchUsername($db, $username) {
        $req = $db->prepare("SELECT users.username, users.profile_picture_path FROM users WHERE username LIKE :username");
        $req->bindValue(':username', '%' . $username . '%');
        $req->execute();
        $posts = $req->fetchAll();
        return $posts;
}

function searchPost($db, $postText) {
    $req = $db->prepare("SELECT posts.content, users.username, users.profile_picture_path FROM posts INNER JOIN users ON posts.id_user = users.id WHERE content LIKE :text");
    $req->bindValue(':text', '%' . $postText . '%');
    $req->execute();
    $posts = $req->fetchAll();
    return $posts;
}


function performSearch($searchText, $searchType) {
    global $db;

    if ($searchType === 'Usernames') {
        return searchUsername($db, $searchText);
    } else if ($searchType === 'Posts') {
        return searchPost($db, $searchText);
    } else {
        return [];
    }
}