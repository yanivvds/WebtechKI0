<?php

$host = "localhost";
$dbname = "travelinsider";
$username = "root";
$password = "Shellshockers123";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL " . $mysqli->connect_error);
}

return $mysqli;