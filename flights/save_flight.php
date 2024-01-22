<?php

include('/../database.php');

$flightID = $_POST['flightID'];
$userID = $_POST['userID'];


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
