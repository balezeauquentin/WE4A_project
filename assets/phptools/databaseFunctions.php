<?php

function validateUserInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function verifPassword($password, $confirmpassword)
{
    if ($password != $confirmpassword) {
        return 1;
    }
    else return 0;
}

function getPostsByUser ($bdd, $username) {
    try {
        $sql = "SELECT * FROM posts WHERE username = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}

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

function updateProfile ($bdd, $username, $email, $profile_picture, $banner, $bio, $password) {
    validateUserInput($email);
    validateUserInput($bio);
    validateUserInput($password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $profile_picture = file_get_contents($profile_picture['tmp_name']);
    $banner = file_get_contents($banner['tmp_name']);
    try {
        $sql = "UPDATE users SET email = ?, profile_picture = ?, banner = ?, bio= ?, password = ? WHERE username = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$email, $profile_picture, $banner, $bio, $password, $username]);
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}
