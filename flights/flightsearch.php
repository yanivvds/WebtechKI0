<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
.flight-offer {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    position: relative; /* Add this to position the Save button */
}

.itinerary {
    margin-top: 10px;
    padding: 5px;
    background-color: #f9f9f9;
}

.segment {
    padding: 5px;
    border-top: 1px solid #eee;
}

.save-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #007bff;
    color: #fff;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
}

.save-button:hover {
    background-color: #0056b3;
}
.body {
    background-color: #f9f9f9;
}
</style>
</head>
<body>
<?php require_once("../navbar.php"); ?>
<?php
include('flightapi.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userID = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["user_id"])) {
        $userID = $_SESSION["user_id"];
    }
}

// Initialize cURL session
$ch = curl_init();

// Define the required parameters for hotel search
$cityCode = $_POST['cityCode'] ?? 'PAR'; // Example city code
$checkInDate = $_POST['checkInDate'] ?? date('Y-m-d', strtotime('+1 day'));
$checkOutDate = $_POST['checkOutDate'] ?? date('Y-m-d', strtotime('+8 day'));
$adults = $_POST['adults'] ?? 1;

// Set cURL options for hotel search
curl_setopt($ch, CURLOPT_URL, "https://test.api.amadeus.com/v1/reference-data/locations/hotels/by-city?cityCode=$cityCode");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/x-www-form-urlencoded'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session and get the response for hotels
$response = curl_exec($ch);
$responseArray = json_decode($response, true);

curl_close($ch);

if (isset($responseArray['data']) && is_array($responseArray['data'])) {
    foreach ($responseArray['data'] as $offer) {
        echo "<div class='flight-offer'>";

        echo "<h2>Price: " . $offer['price']['total'] . " " . $offer['price']['currency'] . "</h2>";

        foreach ($offer['itineraries'] as $itinerary) {
            echo "<div class='itinerary'>";
            echo "<p>Duration: " . $itinerary['duration'] . "</p>";
            $layovers = count($itinerary['segments']) - 1;
            $offer['layovers'] = $layovers;
            echo "<p>Layovers: " . $layovers . "</p>";
            foreach ($itinerary['segments'] as $segment) {
                echo "<div class='segment'>";
                echo "<p>From: " . $segment['departure']['iataCode'] . " at " . $segment['departure']['at'] . "</p>";
                echo "<p>To: " . $segment['arrival']['iataCode'] . " at " . $segment['arrival']['at'] . "</p>";
                echo "<p>Airline: " . $segment['carrierCode'] . " Flight Number: " . $segment['number'] . "</p>";
                echo "</div>"; // .segment
            }
            echo "</div>"; // .itinerary
        }

       
        $offerJson = htmlspecialchars(json_encode($offer), ENT_QUOTES, 'UTF-8');
        echo "<button class='save-button' onclick='saveFlight($offerJson, $userID)'>Save</button>";
        
        echo "</div>"; 
    }
} else {
    echo "<p>No flight offers found.</p>";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function saveFlight(offer, userID) {
    if (userID === null) {
        alert('User is not logged in.');
        return;
    }
    const firstItinerary = offer.itineraries[0];
    const firstSegment = firstItinerary.segments[0];
    const lastSegment = firstItinerary.segments[firstItinerary.segments.length - 1];
    const layovers = offer.layovers;

    const secondItinerary = offer.itineraries[1];
    const firstSegmentReturn = secondItinerary.segments[0];
    const lastSegmentReturn = secondItinerary.segments[secondItinerary.segments.length - 1];
    const layoversReturn = secondItinerary.segments.length - 1; 

    console.log("Departure DateTime:", firstSegment.departure.at); // WEG NA TESTEN!!
    console.log("Arrival DateTime:", lastSegment.arrival.at);
    console.log("Return Departure DateTime:", firstSegmentReturn.departure.at);
    console.log("Return Arrival DateTime:", lastSegmentReturn.arrival.at);


    $.ajax({
        url: '/flights/save_flight.php',
        type: 'POST',
        data: {
            airline: firstSegment.carrierCode,
            flightNumber: firstSegment.number,
            departureAirport: firstSegment.departure.iataCode,
            arrivalAirport: lastSegment.arrival.iataCode,
            departureDateTime: firstSegment.departure.at,
            arrivalDateTime: lastSegment.arrival.at, 
            ticketPrice: offer.price.total,
            layovers: layovers,

            returnAirline: firstSegmentReturn.carrierCode,
            returnFlightNumber: firstSegmentReturn.number,
            returnDepartureAirport: firstSegmentReturn.departure.iataCode,
            returnArrivalAirport: lastSegmentReturn.arrival.iataCode,
            returnDepartureDateTime: firstSegmentReturn.departure.at,
            returnArrivalDateTime: lastSegmentReturn.arrival.at,
            returnLayovers: layoversReturn
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Flight saved successfully!');
            } else {
                alert('Error saving flight: ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
}
</script>
</body>
</html>
