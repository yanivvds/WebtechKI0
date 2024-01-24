<?php
error_reporting(E_ALL); // remove after testing
ini_set('display_errors', 1); // remove after testing

// Start output buffering
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

include('flightapi.php');
include '/var/www/database.php';

if (!isset($_SESSION["user_id"])) {
} else {
    $userID = $_SESSION["user_id"];
    
}
    
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
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("ssssssd", $airline, $flightNumber, $departureAirport, $arrivalAirport, $departureDateTime, $arrivalDateTime, $ticketPrice);
        
        if ($stmt->execute()) {
            // Get the generated FlightID
            $flightID = $mysqli->insert_id;
            
            $sql2 = "INSERT INTO UserFlights (UserID, FlightID) VALUES (?, ?)";
            
            // execute the query
            $stmt2 = $mysqli->prepare($sql2);
            if ($stmt2) {
                $stmt2->bind_param("ii", $userID, $flightID);
                
                if ($stmt2->execute()) {
                    $response = ['success' => true];
                } else {
                    // Error 
                    $response = ['success' => false, 'error' => 'Error executing UserFlights insert'];
                }
                $stmt2->close();
            } else {
                $response = ['success' => false, 'error' => 'Error preparing UserFlights insert'];
            }
        } else {
            // Error inserting flight details into the Flight table
            $response = ['success' => false, 'error' => 'Error executing Flight insert'];
        }
        $stmt->close();
    } else {
        $response = ['success' => false, 'error' => 'Error preparing Flight insert'];
    }
    
    // Log the output just before sending the JSON response
    $output = ob_get_contents();
    error_log("Captured Output: " . $output);

    // Clean the output buffer and turn off output buffering
    ob_end_clean();

    // Set header and return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $mysqli->close();
    exit;
}
?>
