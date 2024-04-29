<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();

if (isset($_POST['user']) && isset($_POST['password'])) {
    $username = validateUserInput($_POST['user']);
    $password = validateUserInput($_POST['password']);
    if (!empty($username) and !empty($password)) {
        $req = $db->prepare("SELECT id,email, username,password,profile_picture_path,admin,isbanned FROM users WHERE username = ?");
        $req->execute(array($username));
        $isUserExist = $req->rowCount();
        if ($isUserExist) {
            $userData = $req->fetch();
            if ($userData['isbanned'] == 0) {
                if (password_verify($password, $userData['password'])) {
                    //if ($user['verified']) {
                        $_SESSION['id'] = $userData['id'];
                        $_SESSION['username'] = $userData['username'];
                        if (empty($username['profile_picture_path'])) {
                            $_SESSION['profile_picture_path'] = null;
                        } else {
                            $_SESSION['profile_picture_path'] = $userData['profile_picture_path'];
                        }
                        $_SESSION['admin'] = $userData['admin'];
                    //} else {
                        //$error = "Your account is not verified. Please check your email.";
                    //}
                } else {
                    $error = "Invalid password or username.";
                }
            } else {
                $error = "Your account has been banned.";
            }
        } else {
            $error = "Invalid password or username.";
        }
    } else {
        $error = "All fields are required.";
    }
} else {
    $error = "Your account has been banned.";
}

if (isset($error)) {
    header('Content-Type: application/json');
    echo json_encode(array('error' => true, 'message' => $error));
}
