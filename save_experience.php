<?php
error_reporting(E_ALL); // remove after testing
ini_set('display_errors', 1); // remove after testing


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

include('activitiesapi.php');
include('../database.php');


if (!isset($_SESSION["user_id"])) {
} else {
    $userID = $_SESSION["user_id"];
    
}
    
// All experience room info
$activityName = $_POST['activityName'] ?? '';
$activityDescription = $_POST['activityDescription'] ?? '';
$activityPrice = $_POST['activityPrice'] ?? 0.0;
$activityCurrency = $_POST['activityCurrency'] ?? '';
$userID = $_SESSION["user_id"];

    $mysqli = require __DIR__ . "/../database.php";

    $sql = "INSERT INTO Experience (ActivityName, ActivityDescription, ActivityPrice, ActivityCurrency) 
    VALUES (?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    var_dump($activityName, $activityDescription, $activityPrice, $activityCurrency);
    if ($stmt->prepare($sql)) {
       $stmt->bind_param("ssds", 
       $activityName, $activityDescription, $activityPrice, $activityCurrency);
        
        if ($stmt->execute()) {
            // Get the generated FlightID
            $ActivityId = $mysqli->insert_id;

            
            $sql2 = "INSERT INTO UserActivity (UserID, ActivityID) VALUES (?, ?)";
            
            // execute the query
            $stmt2 = $mysqli->prepare($sql2);
            if ($stmt2) {
                $stmt2->bind_param("ii", $userID, $ActivityId);
                
                if ($stmt2->execute()) {
                    $response = ['success' => true];
                } else {
                    // Error 
                    $response = ['success' => false, 'error' => 'Error executing UserActivity insert'];
                }
                $stmt2->close();
            } else {
                $response = ['success' => false, 'error' => 'Error preparing UserActivity insert'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Error executing Activity insert'];
        }
        $stmt->close();
    } else {
        $response = ['success' => false, 'error' => 'Error preparing Activity insert'];
    }
    

    // Set header and return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $mysqli->close();
    exit;
?>
