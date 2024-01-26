<?php
error_reporting(E_ALL); // remove after testing
ini_set('display_errors', 1); // remove after testing


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

include('hotelapi.php');
include('/../database.php');

if (!isset($_SESSION["user_id"])) {
} else {
    $userID = $_SESSION["user_id"];
    
}
    
// All hotel room info
$HotelName = $_POST['HotelName'] ?? '';
$offerId = $_POST['offerId'] ?? '';
$checkInDate = date('Y-m-d', strtotime($_POST['checkInDate'] ?? ''));
$checkOutDate = date('Y-m-d', strtotime($_POST['checkOutDate'] ?? ''));
$cityCode = $_POST['cityCode'] ?? '';
$roomType = $_POST['roomType'] ?? '';
$bedDetails = $_POST['bedDetails'] ?? '';
$roomDescription = $_POST['roomDescription'] ?? '';
$priceTotal = $_POST['priceTotal'] ?? 0.0;
$currency = $_POST['currency'] ?? '';
$paymentType = $_POST['paymentType'] ?? '';
$cancellationDeadline = $_POST['cancellationDeadline'] ?? '';
$cancellationFee = $_POST['cancellationFee'] ?? '';


    $mysqli = require __DIR__ . "/../database.php";

    $sql = "INSERT INTO HotelRoom (HotelName, OfferId, CheckInDate, CheckOutDate, CityCode, RoomType, BedDetails, RoomDescription, PriceTotal, Currency, PaymentType, CancellationDeadline, CancellationFee) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare($sql)) {
       $stmt->bind_param("ssssssssdssss", 
       $HotelName, $offerId, $checkInDate, $checkOutDate, $cityCode, 
       $roomType, $bedDetails, $roomDescription, $priceTotal, $currency,
       $paymentType, $cancellationDeadline, $cancellationFee);
        
        if ($stmt->execute()) {
            // Get the generated FlightID
            $roomId = $mysqli->insert_id;

            
            $sql2 = "INSERT INTO UserRooms (UserID, RoomID) VALUES (?, ?)";
            
            // execute the query
            $stmt2 = $mysqli->prepare($sql2);
            if ($stmt2) {
                $stmt2->bind_param("ii", $userID, $roomId);
                
                if ($stmt2->execute()) {
                    $response = ['success' => true];
                } else {
                    // Error 
                    $response = ['success' => false, 'error' => 'Error executing UserRooms insert'];
                }
                $stmt2->close();
            } else {
                $response = ['success' => false, 'error' => 'Error preparing UserRooms insert'];
            }
        } else {
            // Error inserting flight details into the Flight table
            $response = ['success' => false, 'error' => 'Error executing HotelRoom insert'];
        }
        $stmt->close();
    } else {
        $response = ['success' => false, 'error' => 'Error preparing HotelRoom insert'];
    }
    

    // Set header and return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $mysqli->close();
    exit;
?>
