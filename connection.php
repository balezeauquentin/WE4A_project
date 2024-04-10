<?php
$bdd = null;
try {
   $bdd = new PDO('mysql:host=localhost;dbname=Z;charset=utf8', 'php_access', 'o4IQvC9u3-x77pSf', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
   die('Error : ' . $e->getMessage()); // print the error message
}
?>