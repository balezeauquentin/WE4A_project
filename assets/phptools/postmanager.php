<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();
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
        'comment_count' => $post['comment_count'],
        'isbanned' => $post['isbanned'],
        'admin' => $post['admin'],
    ];
    return $postInfo;
}

function getPostByUser($id_user)
{

    global $db;
    $query = $db->prepare("
    SELECT posts.*, users.isbanned, users.admin, users.username, users.profile_picture_path as profile_picture_path, likes.id as like_id,
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
    SELECT posts.*, users.isbanned, users.admin, users.username, users.profile_picture_path as profile_picture_path, likes.id as like_id,
    (SELECT COUNT(*) FROM posts WHERE posts.id_parent = posts.id) as comment_count,
    (SELECT COUNT(*) FROM likes WHERE likes.id_post = posts.id) as like_count
  FROM posts
  INNER JOIN users ON posts.id_user = users.id
  LEFT JOIN likes ON posts.id = likes.id_post AND likes.id_user
  WHERE posts.id = :id
  LIMIT 1");
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $post = $query->fetch();
    if ($post) {
        $posts['content'] = validateSqlOutput($post['content']);
        $postInfo = getPostInfo($post);
        echo json_encode($postInfo);
    } else {
        echo json_encode(array('error' => true, 'message' => 'Post not found'));
    }
}

function getRandomPost($start, $token)
{
    global $db;
    $query = $db->prepare("
    SELECT posts.*, users.username, users.isbanned, users.admin, users.profile_picture_path as profile_picture_path, likes.id as like_id,
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

function sendPost($id_parent, $id_user, $content, $image)
{
    global $db;

    $query = $db->prepare("INSERT INTO posts (id_parent, id_user, content) VALUES (:id_parent, :id_user, :content)");
    $query->bindValue(':id_parent', $id_parent, PDO::PARAM_INT);
    $query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $query->bindValue(':content', $content);
    $query->execute();

    $id_post = $db->lastInsertId();

    if ($image !== null) {
        $root_dir = dirname(__FILE__, 3); // Go up 3 levels to get the root directory
        $post_img_dir = $root_dir . '/post_img/' . $id_post . "/";
        $image_path = $post_img_dir . '/image' . pathinfo($image['name'], PATHINFO_EXTENSION);
        mkdir($post_img_dir, 0777, true);
        move_uploaded_file($image['tmp_name'], $image_path);

        $query = $db->prepare("INSERT INTO images (id_post, path) VALUES (:id_post, :path)");
        $query->bindValue(':id_post', $id_post, PDO::PARAM_INT);
        $query->bindValue(':path', $image_path);
        $query->execute();

        if (!move_uploaded_file($image['tmp_name'], $image_path)) {
            echo json_encode(array('error' => true, 'message' => 'Failed to upload image'));
            return;
        }
    }

    if($id_parent > 0){
        $query = $db->prepare("SELECT id_user FROM posts WHERE id = :id_parent");
        $query->bindValue(':id_parent', $id_parent, PDO::PARAM_INT);
        $query->execute();
        $parent = $query->fetch();
        $query = $db->prepare("INSERT INTO notifications (user_id ,  content, type) VALUES (:id_user, :content, :type)");
        $query->bindValue(':id_user', $parent['id_user'], PDO::PARAM_INT);
        $message = "@" . $_SESSION['username'] . " responded to your post #" . $id_parent;
        $query->bindValue(':content', $message , PDO::PARAM_STR);
        $query->bindValue(':type', 'comment', PDO::PARAM_STR);
        $query->execute();
    }



    echo json_encode(array('success' => true, 'message' => 'Post created'));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['getPostById'])) {
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['responseToPost'])) {
        if (isset($_POST['parentId']) && isset($_POST['userId'])) {
            if (!isset($_POST['responseText'])) {
                echo json_encode(array('error' => false, 'message' => 'Your response is empty'));
                return;
            }

            $content = validateUserInput($_POST['responseText']);
            $image = (isset($_FILES['image']) && $_FILES['image']['error'] === 0) ? $_FILES['image'] : null;

            sendPost($_POST['parentId'], $_POST['userId'], $content, $image);
        }
    } else if (isset($_POST['sendPost'])){
        if (isset($_POST['userId'])) {
            if (!isset($_POST['content'])) {
                echo json_encode(array('error' => false, 'message' => 'Your post is empty'));
            }

            $content = validateUserInput($_POST['content']);
            $image = (isset($_FILES['image']) && $_FILES['image']['error'] === 0) ? $_FILES['image'] : null;

            sendPost(0, $_POST['userId'], $content, $image);
        }
    }
}