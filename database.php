<?php

$host = "localhost";
$username = "yanivs";
$dbname = "travelinsider";
$password = "Od!-m3/[6lx0NI4M";


$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL " . $mysqli->connect_error);
}

return $mysqli;