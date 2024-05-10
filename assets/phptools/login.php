<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();

if (isset($_POST['user']) && isset($_POST['password-l'])) {
    $username = validateUserInput($_POST['user']);
    $password = validateUserInput($_POST['password-l']);
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
                        $_SESSION['profile_picture_path'] = $userData['profile_picture_path'];
                        if (empty($_SESSION['profile_picture_path'])) {
                            $_SESSION['profile_picture_path'] = 'user_img/0/pp.png';
                        } else {
                            $_SESSION['profile_picture_path'] = $userData['profile_picture_path'];
                        }
                        $_SESSION['admin'] = $userData['admin'];
                        $success = "You are now logged in.";
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
} else if (isset($success)){
    header('Content-Type: application/json');
    echo json_encode(array('success' => true, 'message' => $success, 'userId' => $_SESSION['id'], 'username' => $_SESSION['username'], 'admin' => $_SESSION['admin']));
}
