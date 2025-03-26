<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'system');

$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$default_password = 'polkoks';
if ($link->connect_error) {
    die("ERROR: Could not connect. " . $link->connect_error);
}
$link->set_charset("utf8mb4");

