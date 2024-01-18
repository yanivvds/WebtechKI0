<?php
session_start();
include '/var/www/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_SESSION["user_id"];
    $firstName = $_POST["firstName"] ?? '';
    $lastName = $_POST["lastName"] ?? '';
    $city = $_POST["city"] ?? '';
    $phoneNumber = $_POST["phoneNumber"] ?? '';
    $birthday = $_POST["birthday"] ?? '';


    $stmt = $mysqli->prepare("UPDATE Users SET firstName = ?, lastName = ?, city = ?, phoneNumber = ?, birthday = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $firstName, $lastName, $city, $phoneNumber, $birthday, $id);


    if ($stmt->execute()) {
        echo "<script>alert('Information updated successfully');</script>";
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
