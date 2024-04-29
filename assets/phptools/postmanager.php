<?php
function getPostsUser($bdd, $id_user)
{
    $query = $bdd->prepare("
    SELECT users.username, users.profile_picture_path, posts.*, 
    (SELECT COUNT(*) FROM likes WHERE likes.id_post = posts.id) as like_count
FROM users 
INNER JOIN posts ON users.id = posts.id_user 
WHERE users.id = :id_user 
ORDER BY posts.id DESC
    ");
    $query->bindParam(':id_user', $id_user);
    $query->execute();
    $results = $query->fetchAll();

    if ($results) {
        foreach ($results as $result) {
            $profile_data = array(
                'username' => $result['username'],
                'profile_picture_path' => $result['profile_picture_path'],
            );
            $post = array(
                'content' => $result['content'],
                'like_count' => $result['like_count'],
                // add other post fields here...
            );
            include 'template_post.php';
        }
    } else {
        // ...
    }
}

function getPostsById($bdd, $id)
{
    $query_content = $bdd->prepare("SELECT * FROM posts WHERE id = :id ORDER BY id DESC");
    $query_content->bindParam(':id', $id);
    $query_content->execute();
    $posts = $query_content->fetchAll();
    if ($posts) {
        foreach ($posts as $post) {
            $id_user = $posts['id_user'];
            $query_user = $bdd->prepare("SELECT * FROM users WHERE id = :id_user");
            $query_user->bindParam(':id_user', $id_user);
            $query_user->execute();
            $profile_data = $query_user->fetch();
            include 'template_post.php';
        }
    } else {
        // ...
    }
}