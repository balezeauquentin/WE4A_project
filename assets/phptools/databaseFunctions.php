<?php

require_once dirname(__FILE__) . '/dbconnection.php';
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
    

