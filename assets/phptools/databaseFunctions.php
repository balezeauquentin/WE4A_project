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
    $password = password_hash($password, PASSWORD_DEFAULT);;

    // Check if a profile picture was uploaded
    if (is_uploaded_file($profile_picture['tmp_name'])) {
        $profile_picture = file_get_contents($profile_picture['tmp_name']);
    } else {
        $profile_picture = null; // or existing profile picture
    }

    // Check if a banner was uploaded
    if (is_uploaded_file($banner['tmp_name'])) {
        $banner = file_get_contents($banner['tmp_name']);
    } else {
        $banner = null; // or existing banner
    }

    try {
        $sql = "UPDATE users SET email = ?, bio= ?, password = ? WHERE username = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$email, $bio, $password, $username]);

        if ($profile_picture !== null) {
            $sql = "UPDATE users SET profile_picture = ? WHERE username = ?";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([$profile_picture, $username]);
        }

        if ($banner !== null) {
            $sql = "UPDATE users SET banner = ? WHERE username = ?";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([$banner, $username]);
        }
        header("Location: profile.php?username=" . $username);
        exit;
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}

function createUser ($bdd, $username, $firstname, $lastname, $birthdate, $email, $password) {
	$username = validateUserInput($_POST['username']);
	$firstname = validateUserInput($_POST['firstname']);
	$lastname = validateUserInput($_POST['lastname']);
	$email = $_POST['email'];
	$password = validateUserInput($_POST['password']);
	$confirm_password = validateUserInput($_POST['confirm_password']);
	$day = validateUserInput($_POST['day']);
	$years = validateUserInput($_POST['year']);
	verifPassword($password, $confirm_password);
	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
	if ($day > 0 && $day < 32) {
		$birthdate = $years . '-' . $_POST['month'] . '-' . $day;
	}
	// Register user
	try {
		$request = $bdd->prepare("INSERT INTO users (username, firstname, lastname, birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		$request->execute([$username, $firstname, $lastname, $birthdate, $email, $passwordHash]);
	} catch (PDOException $e) {
		die('Error: ' . $e->getMessage());
	}
}