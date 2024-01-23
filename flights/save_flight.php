<?php
session_start();

include('flightapi.php');
include '/var/www/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["user_id"];
    
    // All flight info
    $airline = $_POST['airline'];
    $flightNumber = $_POST['flightNumber'];
    $departureAirport = $_POST['departureAirport'];
    $arrivalAirport = $_POST['arrivalAirport'];
    $departureDateTime = $_POST['departureDateTime'];
    $arrivalDateTime = $_POST['arrivalDateTime'];
    $ticketPrice = $_POST['ticketPrice'];
    
    // To php admin
    $sql = "INSERT INTO Flight (Airline, FlightNumber, DepartureAirport, ArrivalAirport, DepartureDateTime, ArrivalDateTime, TicketPrice) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssd", $airline, $flightNumber, $departureAirport, $arrivalAirport, $departureDateTime, $arrivalDateTime, $ticketPrice);
    
    if ($stmt->execute()) {
        // get back the generated flightid
        $flightID = mysqli_insert_id($conn);
        
       
        $sql2 = "INSERT INTO UserFlights (UserID, FlightID) VALUES (?, ?)";
        
        // execute the query
        $stmt2 = $conn->prepare($sql2);
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
    header('Content-Type: application/json');
    echo json_encode($response);

    $stmt2->close();
    $stmt->close();
    $conn->close();
}
?>
