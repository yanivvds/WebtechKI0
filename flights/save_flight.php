<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

include('flightapi.php');
include('../../database.php');

if (!isset($_SESSION["user_id"])) {
} else {
    $userID = $_SESSION["user_id"];
    
}
    
    // All flight info
    $airline = $_POST['airline'] ?? '';
    $flightNumber = $_POST['flightNumber'] ?? '';
    $departureAirport = $_POST['departureAirport'] ?? '';
    $arrivalAirport = $_POST['arrivalAirport'] ?? '';
    $departureDateTime = date('Y-m-d H:i:s', strtotime($_POST['departureDateTime'] ?? ''));
    $arrivalDateTime = date('Y-m-d H:i:s', strtotime($_POST['arrivalDateTime'] ?? ''));
    $ticketPrice = $_POST['ticketPrice'] ?? 0.0;
    $layovers = $_POST['layovers'] ?? 0;
    
    $returnAirline = $_POST['returnAirline'] ?? '';
    $returnFlightNumber = $_POST['returnFlightNumber'] ?? '';
    $returnDepartureAirport = $_POST['returnDepartureAirport'] ?? '';
    $returnArrivalAirport = $_POST['returnArrivalAirport'] ?? '';
    $returnDepartureDateTime = date('Y-m-d H:i:s', strtotime($_POST['returnDepartureDateTime'] ?? ''));
    $returnArrivalDateTime = date('Y-m-d H:i:s', strtotime($_POST['returnArrivalDateTime'] ?? ''));
    $returnLayovers = $_POST['returnLayovers'] ?? 0;


    $mysqli = require __DIR__ . "/../../database.php";

    $sql = "INSERT INTO Flight (Airline, FlightNumber, DepartureAirport, ArrivalAirport, DepartureDateTime, ArrivalDateTime, TicketPrice, Layovers, ReturnAirline, ReturnFlightNumber, ReturnDepartureAirport, ReturnArrivalAirport, ReturnDepartureDateTime, ReturnArrivalDateTime, ReturnLayovers) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare($sql)) {
       $stmt->bind_param("ssssssdissssssi", 
    $airline, $flightNumber, $departureAirport, $arrivalAirport, 
    $departureDateTime, $arrivalDateTime, $ticketPrice, $layovers, 
    $returnAirline, $returnFlightNumber, $returnDepartureAirport, 
    $returnArrivalAirport, $returnDepartureDateTime, $returnArrivalDateTime, 
    $returnLayovers);
        
        if ($stmt->execute()) {
            // Get the generated FlightID
            $flightID = $mysqli->insert_id;
            error_log("Formatted Departure DateTime 2: $departureDateTime");
            error_log("Formatted Arrival DateTime 2: $arrivalDateTime");
            error_log("Formatted Return Departure DateTime 2: $returnDepartureDateTime");
            error_log("Formatted Return Arrival DateTime 2: $returnArrivalDateTime");

            
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
    

    // Set header and return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $mysqli->close();
    exit;
?>
