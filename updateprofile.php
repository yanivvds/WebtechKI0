<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_SESSION["user_id"];
    $firstName = $_POST["firstName"] ?? '';
    $lastName = $_POST["lastName"] ?? '';
    $homeLocation = $_POST["homeLocation"] ?? '';
    $phoneNumber = $_POST["phoneNumber"] ?? '';
    $birthday = $_POST["birthday"] ?? '';


    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, city = ?, phone_number = ?, birthday = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $firstName, $lastName, $homeLocation, $phoneNumber, $birthday, $id);


    if ($stmt->execute()) {
        echo "Profile updated successfully";

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
