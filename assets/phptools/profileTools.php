<?php

function getProfileData ($bdd, $username) {
    try {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}

function updateProfile ($bdd, $username, $email, $profile_picture, $banner, $bio, $password, $current_profile_picture_path, $current_banner_path) {
    validateUserInput($email);
    validateUserInput($bio);
    validateUserInput($password);

    // Define the target directory and file names
    $root_dir = dirname(__FILE__, 3); // Go up 3 levels to get the root directory
    $user_img_dir = $root_dir . '/user_img/' . $username . "/";
   

    $pp_name = "pp." . pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
    $banner_name = "banner." . pathinfo($banner['name'], PATHINFO_EXTENSION);


    // Create the target directory if it doesn't exist
    if (!file_exists($user_img_dir)) {
        if (!mkdir($user_img_dir, 0777, true)) {
            die('Failed to create directory');
        }
    } 

    // Move the uploaded files to the target directory and rename them
    if (!empty($profile_picture['tmp_name'])) {
        if(file_exists($current_profile_picture_path)){
            unlink($current_profile_picture_path); // Delete the current profile picture before moving the new one
        }
       
        $pp_path = $user_img_dir . $pp_name;
        $pp_path_db = "user_img/" . $username . "/" . $pp_name; // Save the path to the database in the format "user_img/username/pp.jpg
       
        move_uploaded_file($profile_picture['tmp_name'], $pp_path);
    } else {
        $pp_path_db = $current_profile_picture_path; // Use current profile picture path if no new picture is uploaded
    }
    
    // Move the uploaded banner to the target directory and rename it
    if (!empty($banner['tmp_name'])) {
        if(file_exists($current_banner_path)){
            unlink($current_banner_path); // Delete the current profile picture before moving the new one
        }

        $banner_path = $user_img_dir . $banner_name;
        $banner_path_db = "user_img/" . $username . "/" . $banner_name; // Save the path to the database in the format "user_img/username/banner.jpg
       
        move_uploaded_file($banner['tmp_name'],$banner_path);

    } else {
        $banner_path_db = $current_banner_path; // Use current banner path if no new banner is uploaded
    }

    
    try {
        $sql = "UPDATE users SET email = ?, profile_picture_path = ?, banner_path = ?, bio = ? WHERE username = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$email, $pp_path_db, $banner_path_db, $bio, $username]);
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}