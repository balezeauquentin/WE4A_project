<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();
function updatesettings($id, $email, $address, $city, $zip_code, $country, $password, $password_confirm, $old_password)
{
    global $db;

    $email = validateUserInput($email);
    $address = validateUserInput($address);
    $city = validateUserInput($city);
    $zip_code = validateUserInput($zip_code);
    $country = validateUserInput($country);


    // Update users table
    if (!empty($email)) {
        $query = $db->prepare("UPDATE users SET email = :email WHERE id = :id");
        $query->execute([
            ':email' => $email,
            ':id' => $id
        ]);
    } else {
        echo json_encode(['error' => 'Email is required']);
    }

    // Update info_user table
    if (!empty($address) && !empty($city) && !empty($zip_code) && !empty($country)) {
        $query = $db->prepare("UPDATE user_info SET address = :address, city = :city, zip_code = :zip_code, country = :country WHERE id_user = :id");
        $query->execute([
            ':address' => $address,
            ':city' => $city,
            ':zip_code' => $zip_code,
            ':country' => $country,
            ':id' => $id
        ]);
    } else {
        echo json_encode(['error' => 'All fields are required']);
    }


    if (!empty($password) || !empty($password_confirm) || !empty($old_password)) {
        // Check if the old password is correct
        if(!empty($old_password)) {
        $query = $db->prepare("SELECT password FROM users WHERE id = :id");
        $query->execute([
            ':id' => $id
        ]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (password_verify($old_password, $row['password'])) {
            // Check if the new password and the confirmation match
            if ($password === $password_confirm) {
                // Update the password
                $query = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
                $query->execute([
                    ':password' => password_hash($password, PASSWORD_DEFAULT),
                    ':id' => $id
                ]);
            } else {
                echo json_encode(['error' => 'The new password and the confirmation do not match']);
            }
        } else {
            echo json_encode(['error' => 'The actual password is incorrect']);
        }
    } else {
        echo json_encode(['error' => 'Provide your actual password']);
    }

    echo json_encode(['success' => 'Your information has been updated']);
}
}

function getSettingsInfo ($id) {
    global $db;
    $query = $db->prepare("SELECT u.email, ui.address, ui.city, ui.zip_code, ui.country 
    FROM users u 
    INNER JOIN user_info ui ON u.id = ui.id_user 
    WHERE u.id = :id;");
    $query->execute([
        ':id' => $id
    ]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
    $old_password = $_POST['old-password'];
    updatesettings($id, $email, $address, $city, $zip_code, $country, $password, $password_confirm, $old_password);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getSettingsInfo($_GET['userId']);
}
