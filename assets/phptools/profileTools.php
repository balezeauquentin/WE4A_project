<?php
require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();
function getProfileData($username)
{

        global $db; 
        
        $query = $db->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        $userInfo = $query->fetch(PDO::FETCH_ASSOC);

        $query = $db->prepare("SELECT users.*, user_info.birthdate 
                               FROM users 
                               INNER JOIN user_info ON users.id = user_info.id_user 
                               WHERE users.id = :id");
        $query->execute([
            ':id' => $userInfo['id']
        ]);
        
        $userInfo = $query->fetch(PDO::FETCH_ASSOC);
        
        // Count the number of followers and followed people
        $query = $db->prepare("SELECT COUNT(*) AS followers
                               FROM follow
                               WHERE followed_id = :id");
        $query->execute([
            ':id' => $userInfo['id']
        ]);

        $followCount = $query->fetch(PDO::FETCH_ASSOC);
        $userInfo['followers'] = $followCount['followers'];
        $query = $db->prepare("SELECT COUNT(*) AS following
                               FROM follow
                               WHERE follower_id = :id");
        $query->execute([
            ':id' => $userInfo['id']
        ]);
        $followCount = $query->fetch(PDO::FETCH_ASSOC);
        $userInfo['following'] = $followCount['following'];
        //echo all information of my userInfo
        
        return $userInfo;
    }


function updateProfile($username, $profile_picture, $banner, $bio)
{
    global $db;
    validateUserInput($bio);

    $query = $db->prepare("SELECT profile_picture_path, banner_path FROM users WHERE username = ?");
    $query->execute([$username]);
    $pictures_path = $query->fetch(PDO::FETCH_ASSOC);

    $current_profile_picture_path = $pictures_path['profile_picture_path'];
    $current_banner_path = $pictures_path['banner_path'];

    $root_dir = dirname(__FILE__, 3); // Go up 3 levels to get the root directory
    $user_img_dir = $root_dir . '/user_img/' . $username . "/";

    // Create the target directory if it doesn't exist
    if (!file_exists($user_img_dir)) {
        if (!mkdir($user_img_dir, 0777, true)) {
            die('Failed to create directory');
        }
    }

    // Move the uploaded files to the target directory and rename them
    if (!empty($profile_picture['tmp_name']) && $profile_picture !== null) {
        if (file_exists($current_profile_picture_path)) {
            unlink($current_profile_picture_path); // Delete the current profile picture before moving the new one
        }

        $pp_name = "pp." . pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
        $pp_path = $user_img_dir . $pp_name;
        $pp_path_db = "user_img/" . $username . "/" . $pp_name; // Save the path to the database in the format "user_img/username/pp.jpg

        move_uploaded_file($profile_picture['tmp_name'], $pp_path);
    } else {
        $pp_path_db = $current_profile_picture_path; // Use current profile picture path if no new picture is uploaded
    }
  
    // Move the uploaded banner to the target directory and rename it
    if (!empty($banner['tmp_name']) && $banner !== null) {
        if (file_exists($current_banner_path)) {
            unlink($current_banner_path); 
        }
        $banner_name = "banner." . pathinfo($banner['name'], PATHINFO_EXTENSION);
        $banner_path = $user_img_dir . $banner_name;
        $banner_path_db = "user_img/" . $username . "/" . $banner_name; // Save the path to the database in the format "user_img/username/banner.jpg

        move_uploaded_file($banner['tmp_name'], $banner_path);
    } else {
        $banner_path_db = $current_banner_path; // Use current banner path if no new banner is uploaded
    }

    try {
            $sql = "UPDATE users SET profile_picture_path = ?, banner_path = ?, bio = ? WHERE username = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$pp_path_db, $banner_path_db, $bio, $username]);
        } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_SESSION['username'];
        $bio = $_POST['bio'];
        
        $profile_picture = isset($_FILES['profile_picture']) ? $_FILES['profile_picture'] : null;
        $banner = isset($_FILES['banner']) ? $_FILES['banner'] : null; 
        
        updateProfile($username, $profile_picture, $banner, $bio);

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        getProfileData($username);
    }
}   