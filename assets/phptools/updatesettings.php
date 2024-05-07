<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();
function updatesettings($id, $email, $address, $city, $zip_code, $country)
{
    global $db;
    // Update users table
    $query = $db->prepare("UPDATE users SET email = :email WHERE id = :id");
    $query->execute([
        ':email' => $email,
        ':id' => $id
    ]);

    // Update info_user table
    $query = $db->prepare("UPDATE user_info SET address = :address, city = :city, zip_code = :zip_code, country = :country WHERE id_user = :id");
    $query->execute([
        ':address' => $address,
        ':city' => $city,
        ':zip_code' => $zip_code,
        ':country' => $country,
        ':id' => $id
    ]);
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
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getSettingsInfo($_GET['userId']);
}
