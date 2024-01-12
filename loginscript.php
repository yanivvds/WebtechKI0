<?php
$correctUsername = 'admin';
$correctPassword = 'password123';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username === $correctUsername && $password === $correctPassword) {
        echo "Login successful!";
    } else {
        echo "Login failed: Incorrect username or password";
    }
} else {
    echo "Access denied!";
}
?>