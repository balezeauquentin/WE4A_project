<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();
$_SESSION = array();
session_destroy();