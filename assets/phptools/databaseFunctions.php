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

function getPostsByUser ($bdd, $id) {
    try {
        $sql = "SELECT * FROM posts WHERE id_user = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$id]);
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
    // Define the target directory and file names
    $target_dir = "/user_img/" . $username . "/";
    $profile_picture_name = "profile_picture." . pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
    $banner_name = "banner." . pathinfo($banner['name'], PATHINFO_EXTENSION);

    // Create the target directory if it doesn't exist
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die('Failed to create directory');
        }
    }

    // Move the uploaded files to the target directory and rename them
    move_uploaded_file($profile_picture['tmp_name'], $target_dir . $profile_picture_name);
    move_uploaded_file($banner['tmp_name'], $target_dir . $banner_name);

    // Store the paths to the images in the database
    $profile_picture_path = $target_dir . $profile_picture_name;
    $banner_path = $target_dir . $banner_name;

    try {
        $sql = "UPDATE users SET email = ?, profile_picture_path = ?, banner_path = ? WHERE username = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$email, $profile_picture_path, $banner_path, $username]);
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