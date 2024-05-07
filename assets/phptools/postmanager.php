<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';

function getPostInfo($post)
{
    global $db;
    $date = date_create_from_format('Y-m-d H:i:s', $post['creation_date']);
    if ($date === false) {
        throw new Exception("Failed to parse date: " . $post['creation_date']);
    }
    $formatted_date = $date->format('d/m/Y H:i');   
    

    //TODO: get picture path
    $postInfo = [

        'id' => $post['id'],
        'id_user' => $post['id_user'],
        'profile_picture_path' => $post['profile_picture_path'],
        'username' => $post['username'],
        'content' => $post['content'],
        'date' => $formatted_date,
        'like_count' => $post['like_count'],
        'comment_count' => $post['comment_count']
    ];
    return $postInfo;
}

function getPostByUser($id_user)
{

    global $db;
    $query = $db->prepare("
    SELECT posts.*, users.username, users.profile_picture_path as profile_picture_path, likes.id as like_id,
       (SELECT COUNT(*) FROM posts WHERE posts.id_parent = posts.id) as comment_count,
       (SELECT COUNT(*) FROM likes WHERE likes.id_post = posts.id) as like_count
    FROM posts 
    INNER JOIN users ON posts.id_user = users.id 
    LEFT JOIN likes ON posts.id = likes.id_post AND likes.id_user = :id_user
    WHERE posts.id_user = :id_user");
    $query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $query->execute();
    $posts = $query->fetchAll();
    $listPosts = array();
    $listPosts = array();
    if ($posts) {
        foreach ($posts as $post) {
            $post['content'] = validateSqlOutput($post['content']);
            $listPosts[] = getPostInfo($post);
        }
        echo json_encode($listPosts);
    } else {
        echo json_encode(array('error' => true, 'message' => 'No posts found'));
        return;
    }



}


function getPostById($id)
{
    global $db;
    $query = $db->prepare("
    SELECT posts.*, users.username, users.profile_picture_path as profile_picture_path, likes.id as like_id,
           (SELECT COUNT(*) FROM posts WHERE posts.id_parent = posts.id) as comment_count,
           (SELECT COUNT(*) FROM likes WHERE likes.id_post = posts.id) as like_count
    FROM posts 
    INNER JOIN users ON posts.id_user = users.id 
    LEFT JOIN likes ON posts.id = likes.id_post AND likes.id_user = :id");
    $query->bindValue(':id_user', $id, PDO::PARAM_INT);
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
    SELECT posts.*, users.username, users.profile_picture_path as profile_picture_path, likes.id as like_id,
           (SELECT COUNT(*) FROM posts WHERE posts.id_parent = posts.id) as comment_count,
           (SELECT COUNT(*) FROM likes WHERE likes.id_post = posts.id) as like_count
    FROM posts 
    INNER JOIN users ON posts.id_user = users.id 
    LEFT JOIN likes ON posts.id = likes.id_post AND likes.id_user = :id 
    ORDER BY RAND(:seed)
    LIMIT 10 OFFSET :offset");
    $query->bindValue(':id', 1, PDO::PARAM_INT);
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
        if (isset($_GET['userId'])) {
            getPostByUser($_GET['userId']);
        }
    }
    if (isset($_GET['getRandomPost'])) {
        if (isset($_GET['start'])) {
            getRandomPost($_GET['start'], $_GET['token']);
        }
    }
}