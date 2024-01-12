<?php
$correctUsername = 'admin';
$correctPassword = 'password123';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username === $correctUsername && $password === $correctPassword) {
        header("Location: dashboard.html");
    } else {
        echo "Login failed: Incorrect username or password";
    }
} else {
    echo "Access denied!";
}
?>