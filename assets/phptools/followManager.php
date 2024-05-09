<?php
require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();


function alreadyFollowing($id_user, $id_target){
    global $db;

    $query = $db->prepare("SELECT * FROM follow WHERE following_id = ? AND followed_id = ?");
    $query->execute([$id_user, $id_target]);
    $follow = $query->rowCount();

    if ($follow == 0) {
        return false;
    } else {
        return true;
    }
}
function follow_unfollow($id_user, $id_target){
    global $db;

    if (alreadyFollowing($id_user, $id_target) == false) {
        $query = $db->prepare("INSERT INTO follow (following_id, followed_id) VALUES (?, ?)");
        $query->execute([$id_user, $id_target]);
        echo "Follow";
    } else {
        $query = $db->prepare("DELETE FROM follow WHERE following_id = ? AND followed_id = ?");
        $query->execute([$id_user, $id_target]);
        echo "Unfollow";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['follow_unfollow']){
        $userId = $_POST['userId'];
        $targetId = $_POST['targetId'];
        follow_unfollow($userId, $targetId);
    }
}