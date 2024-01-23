<?php
session_start();
include '/var/www/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["user_id"];
}

$airline = $_POST['airline'];
$flightNumber = $_POST['flightNumber'];
$departureAirport = $_POST['departureAirport'];
$arrivalAirport = $_POST['arrivalAirport'];
$departureDateTime = $_POST['departureDateTime'];
$arrivalDateTime = $_POST['arrivalDateTime'];
$ticketPrice = $_POST['ticketPrice'];

$sql = "INSERT INTO Flight (Airline, FlightNumber, DepartureAirport, ArrivalAirport, DepartureDateTime, ArrivalDateTime, TicketPrice) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssd", $airline, $flightNumber, $departureAirport, $arrivalAirport, $departureDateTime, $arrivalDateTime, $ticketPrice);

if ($stmt->execute()) {
   $flightID = $stmt->insert_id;

   $sql = "INSERT INTO UserFlights (UserID, FlightID) VALUES (?, ?)";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("ii", $userID, $flightID);

   if ($stmt->execute()) {
       $response = ['success' => true];
   } else {
       $response = ['success' => false];
   }
} else {
   $response = ['success' => false];
}

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
