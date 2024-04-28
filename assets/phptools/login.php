<?php
require_once dirname(__FILE__) . '/databaseFunction.php';

if (isset($_POST['user']) && isset($_POST['password'])) {
    $email = validateUserInput($_POST['user']);
    $password = validateUserInput($_POST['password']);
    if (!empty($email) and !empty($password)) {
        $req = $db->prepare("SELECT id,email,username,password,profile_picture_path,token,isAdmin FROM users WHERE username = ?");
        $req->execute(array($email));
        $isUserExist = $req->rowCount();
        if ($isUserExist) {
            $userData = $req->fetch();
            if ($userData['isbanned'] == 0) {
                if (password_verify($password, $user['password'])) {
                    if ($user['verified']) {
                        $_SESSION['id'] = $userData['id'];
                        $_SESSION['email'] = $userData['email'];
                        $_SESSION['username'] = $userData['username'];
                        if (empty($user['profile_picture_path'])) {
                            $_SESSION['profile_picture_path'] = null;
                        } else {
                            $_SESSION['profile_picture_path'] = $userData['profile_picture_path'];
                        }
                        $_SESSION['admin'] = $userData['admin'];
                    } else {
                        $error = "Your account is not verified. Please check your email.";
                    }
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