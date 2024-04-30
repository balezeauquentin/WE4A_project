<?php
require_once ("assets/phptools/connection.php");
require_once ("assets/phptools/databaseFunctions.php");
if (isset($_POST['confirm'])) {
	// Validate user input (server-side)
	$username = validateUserInput($_POST['username']);
	$firstname = validateUserInput($_POST['firstname']);
	$lastname = validateUserInput($_POST['lastname']);
	$username = $_POST['email'];
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
		$request = $db->prepare("INSERT INTO users (username, firstname, lastname, birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		$request->execute([$username, $firstname, $lastname, $birthdate, $username, $passwordHash]);
	} catch (PDOException $e) {
		die('Error: ' . $e->getMessage());
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">

	<title>Z</title>

	<!-- Favicons -->
	<link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicon/android-icon-192x192.png">
	<!-- Favicons -->

	<!-- Template Main CSS File -->
	<link rel="stylesheet" href="assets/css/login.css">
	<link rel="stylesheet" href="assets/css/register.css">


	<!-- font -->
	<script src="assets/js/register.js"defer></script>

</head>

<body>
	<div class="container">
		<h1>Register</h1>

	</div>
</body>

</html>