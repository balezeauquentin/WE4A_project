<?php

global $bdd;
try {
   $bdd = new PDO('mysql:host=localhost;dbname=Z;charset=utf8', 'if3', 'o4IQvC9u3-x77pSf', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
   die('Error : ' . $e->getMessage()); // print the error message
}
function session_start_secure() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function validateUserInput($data)
{
    if (empty($data)) {
        return 0;
    }
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
        $sql = "SELECT posts.*, users.username, users.profile_picture_path FROM posts INNER JOIN users ON posts.id_user = users.id WHERE posts.id_user = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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