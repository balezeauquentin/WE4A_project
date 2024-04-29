<?php

function getPostInfo($post)
{
    global $db;
    $date = date_create_from_format('Y-m-d H:i', $post['created_at']);
    $formatted_date = $date->format('d/m/Y H:i');
    $like_image = !is_null($post['like_id']) ? "/WE4A_project/img/icon/liked.png" : "/WE4A_project/img/icon/like.png";
    $avatar = !empty($post['avatar']) ? "/WE4A_project/img/user/" . $post['id_user'] . '/' . $post['avatar'] : "/WE4A_project/img/icon/utilisateur.png";

    //TODO: get picture path

    $postInfo = [
        'id' => $post['id'],
        'id_user' => $post['id_user'],
        'pseudo' => $post['pseudo'],
        'avatar' => $avatar,
        'content' => $post['content'],
        'date' => $formatted_date,
        'like_image' => $like_image,
        'like_count' => $post['like_count'],
        'comment_count' => $post['comment_count']
    ];

    return $postInfo;
}

function getPostByUser($id_user)
{
    global $db;
    $query = $db->prepare("
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


function getPostById($id)
{
    global $db;
    $query = $db->prepare("
    SELECT posts.*, users.username, users.profile_picture_path as avatar, likes.id as like_id,
           (SELECT COUNT(*) FROM posts WHERE posts.id_parent = posts.id) as comment_count,
           (SELECT COUNT(*) FROM likes WHERE likes.id_post = posts.id) as like_count
    FROM posts 
    INNER JOIN users ON posts.id_user = users.id 
    LEFT JOIN likes ON posts.id = likes.id_post AND likes.id_user = :id_user
    WHERE posts.id = :id");
    $query->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $posts = $query->fetch();

    if ($posts) {
        foreach ($posts as $post) {
            $post['content'] = validateSqlOutput($post['content']);
            $postInfo = getPostInfo($post);
        }

        echo json_encode($postInfo);
    } else {
        echo json_encode(array('error' => true, 'message' => 'Post not found'));
    }
}

function getRandomPost($start, $token)
{
    global $db;
    $query = $db->prepare("
    SELECT posts.*, users.username, users.profile_picture_path as avatar, likes.id as like_id,
           (SELECT COUNT(*) FROM posts WHERE posts.id_parent = posts.id) as comment_count,
           (SELECT COUNT(*) FROM likes WHERE likes.id_post = posts.id) as like_count
    FROM posts 
    INNER JOIN users ON posts.id_user = users.id 
    LEFT JOIN likes ON posts.id = likes.id_post AND likes.id_user = :id 
    ORDER BY RAND(:seed)
    LIMIT 10 OFFSET :offset");
    $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    $query->bindValue(':seed', $token);
    $query->bindValue(':offset', $start, PDO::PARAM_INT);
    $query->execute();
    $posts = $query->fetchAll();

    $listPosts = array();
    foreach ($posts as $post) {
        $post['content'] = validateSqlOutput($post['content']);
        $listPosts[] = getPostInfo($post);
    }

    echo json_encode($listPosts);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['getPostByUser'])) {
        if (isset($_GET['postId'])) {
            getPostById($_GET['postId']);
        }
    }
    if (isset($_GET['getPostByUser'])) {
        if (isset($_GET['postId'])) {
            getPostByUser($_GET['userId']);
        }
    }
    if (isset($_GET['getListRandomPosts'])) {
        if (isset($_GET['start'])) {
            getRandomPost($_GET['start'], $_GET['token']);
        }
    }
}