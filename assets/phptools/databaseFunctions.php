<?php

global $db;
try {
   $db = new PDO('mysql:host=localhost;dbname=Z;charset=utf8', 'if3', 'o4IQvC9u3-x77pSf', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
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

function validateSqlOutput($data)
{
    $data = htmlspecialchars_decode($data);
    $data = stripslashes($data);
    return $data;
}
function verifPassword($password, $confirmpassword)
{
    if ($password != $confirmpassword) {
        return 1;
    }
    else return 0;
}


