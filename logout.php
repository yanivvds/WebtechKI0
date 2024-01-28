<?php
// This file is used to logout the user and end the session.
require_once 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_unset();
session_destroy();
header('Location: login.php');
exit();
?>