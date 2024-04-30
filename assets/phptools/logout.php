<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start();
$_SESSION = array();
session_destroy();