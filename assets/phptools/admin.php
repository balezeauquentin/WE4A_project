<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['notifMessage']) && !empty($_POST['notifMessage']) && isset($_POST['adminPostControlId']) && !empty($_POST['adminPostControlId']) && isset($_POST['adminActionType']) && !empty($_POST['adminActionType'])) {
        $content = validateUserInput($_POST['notifMessage']);
        $postId = validateUserInput($_POST['adminPostControlId']);
        $actionType = validateUserInput($_POST['adminActionType']);
        $req = $db->prepare('SELECT id_user FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $userId = $req->fetch()['id_user'];
        if ($actionType == 'sensitive') {
            $req = $db->prepare('UPDATE posts SET sensitive = 1 WHERE id = ?');
            $req->execute(array($postId));
        } else if ($actionType == 'delete') {
            $req = $db->prepare('DELETE FROM posts WHERE id = ?');
            $req->execute(array($postId));
        }


        $req = $db->prepare('INSERT INTO notifications (user_id, type, content) VALUES (?, ?, ?)');
        $req->execute(array($userId, $actionType, $content));
        header('application/json');
        echo json_encode(array('error' => false));
    } else {
        header('application/json');
        echo json_encode(array('error' => true, 'message' => 'Invalid parameters'));
    }
} else {
    header('application/json');
    echo json_encode(array('error' => true, 'message' => 'Invalid request method'));
}