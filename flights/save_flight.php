<?php

session_start();
include '/var/www/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["user_id"];
}

$flightID = $_POST['flightID'];



$sql = "INSERT INTO SavedFlights (UserID, FlightID) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userID, $flightID);

if ($stmt->execute()) {
   $response = ['success' => true];
} else {
   $response = ['success' => false];
}

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
