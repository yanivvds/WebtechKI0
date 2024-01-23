<?php
header('Content-Type: application/json');

error_reporting(E_ALL); // remove after testing
ini_set('display_errors', 1); // remove after testing

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('flightapi.php');
include '/var/www/database.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["user_id"];
    
    // All flight info
    $airline = $_POST['airline'] ?? '';
    $flightNumber = $_POST['flightNumber'] ?? '';
    $departureAirport = $_POST['departureAirport'] ?? '';
    $arrivalAirport = $_POST['arrivalAirport'] ?? '';
    $departureDateTime = $_POST['departureDateTime'] ?? '';
    $arrivalDateTime = $_POST['arrivalDateTime'] ?? '';
    $ticketPrice = $_POST['ticketPrice'] ?? 0.0;
    
    
    $mysqli = require __DIR__ . "/../database.php";

    $sql = "INSERT INTO Flight (Airline, FlightNumber, DepartureAirport, ArrivalAirport, DepartureDateTime, ArrivalDateTime, TicketPrice) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    $stmt->bind_param("ssssssd", $airline, $flightNumber, $departureAirport, $arrivalAirport, $departureDateTime, $arrivalDateTime, $ticketPrice);
    
    if ($stmt->execute()) {
        // Get the generated FlightID
        $flightID = mysqli_insert_id($mysqli);
        
       
        $sql2 = "INSERT INTO UserFlights (UserID, FlightID) VALUES (?, ?)";
        
        // execute the query
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("ii", $userID, $flightID);
        
        if ($stmt2->execute()) {
           
            $response = ['success' => true];
        } else {
            // Error 
            $response = ['success' => false];
        }
    } else {
        // Error inserting flight details into the Flight table
        $response = ['success' => false];
    }
    
    // Handle success or failure and return a JSON response
    console.log(response);
    echo json_encode($response);

    $stmt2->close();
    $stmt->close();
    $mysqli->close();
}
?>
