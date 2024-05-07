<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();

if (isset($_POST['username-r']) && isset($_POST['password-r']) && isset($_POST['mail-r']) && isset($_POST['password2-r'])) {
    $username = validateUserInput($_POST['username-r']);
    $email = validateUserInput($_POST['mail-r']);

    $password = validateUserInput($_POST['password-r']);
    $password2 = validateUserInput($_POST['password2-r']);
    if ($password == $password2) {
        if (isset($_POST['firstname-r']) && isset($_POST['lastname-r']) && isset($_POST['day-r']) && isset($_POST['month-r']) && isset($_POST['year-r'])) {
            $firstname = validateUserInput($_POST['firstname-r']);
            $lastname = validateUserInput($_POST['lastname-r']);

            $day = validateUserInput($_POST['day-r']);
            $month = validateUserInput($_POST['month-r']);
            $year = validateUserInput($_POST['year-r']);
            $date = $year . '-' . $month . '-' . $day;
            if (isset($_POST['address-r']) && isset($_POST['city-r']) && isset($_POST['zipcode-r']) && isset($_POST['country-r'])) {
                $address = validateUserInput($_POST['address-r']);
                $city = validateUserInput($_POST['city-r']);
                $zipcode = validateUserInput($_POST['zipcode-r']);
                $country = validateUserInput($_POST['country-r']);
                if (!empty($username) && !empty($password) && !empty($email) && !empty($firstname) && !empty($lastname) && !empty($date) && !empty($address) && !empty($city) && !empty($zipcode) && !empty($country)){

                    $req = $db->prepare("SELECT id FROM users WHERE username = ?");
                    $req->execute(array($username));
                    $isUserExist = $req->rowCount();

                    if (!$isUserExist) {

                        $req = $db->prepare("SELECT id FROM users WHERE email = ?");
                        $req->execute(array($email));
                        $isEmailExist = $req->rowCount();

                        if (!$isEmailExist) {

                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $req = $db->prepare("INSERT INTO users (username, password, email, registration_date) VALUES (?, ?, ?, NOW())");
                            $req->execute(array($username, $hashed_password, $email));
                            $userId = $db->lastInsertId();

                            $req = $db->prepare("INSERT INTO user_info (id_user, firstname, lastname, birthdate, address, city, zip_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $req->execute(array($userId, $firstname, $lastname, $date, $address, $city, $zipcode, $country));

                            $success = "Registration successful.";
                        } else {
                            $error = "Email already exists.";
                        }
                    } else {
                        $error = "Username already exists.";
                    }
                } else {
                    $error = "All fields are required.";
                }
            } else {
                $error = "All fields are required.";
            }
        } else {
            $error = "All fields are required.";
        }
    } else {
        $error = "Passwords do not match.";
    }
} else {
    $error = "All fields are required.";
}

if (isset($error)) {
    header('Content-Type: application/json');
    echo json_encode(array('error' => true, 'message' => $error));
} else if (isset($success)){
    header('Content-Type: application/json');
    echo json_encode(array('success' => true, 'message' => $success));
}