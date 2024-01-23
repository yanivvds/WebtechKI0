<?php
include('flightapi.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["user_id"])) {
        $userID = $_SESSION["user_id"];
    }
}
// Initialize cURL session
$ch = curl_init();

$origin = $_POST['origin'] ?? 'NYC';
$destination = $_POST['destination'] ?? 'MAD';
$departureDate = $_POST['departureDate'] ?? date('Y-m-d', strtotime('+1 day'));
$returnDate = $_POST['returnDate'] ?? date('Y-m-d', strtotime('+8 day'));
$adults = $_POST['adults'] ?? 1;


// Set cURL options
curl_setopt($ch, CURLOPT_URL, "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=$origin&destinationLocationCode=$destination&departureDate=$departureDate&returnDate=$returnDate&adults=$adults&nonStop=false&max=50");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/x-www-form-urlencoded'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session and get the response
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
            foreach ($itinerary['segments'] as $segment) {
                echo "<div class='segment'>";
                echo "<p>From: " . $segment['departure']['iataCode'] . " at " . $segment['departure']['at'] . "</p>";
                echo "<p>To: " . $segment['arrival']['iataCode'] . " at " . $segment['arrival']['at'] . "</p>";
                echo "<p>Airline: " . $segment['carrierCode'] . " Flight Number: " . $segment['number'] . "</p>";
                echo "</div>"; // .segment
            }
            echo "</div>"; // .itinerary
        }

       
        echo "<button class='save-button' onclick='saveFlight(" . json_encode($offer) . ", " . $userID . ")'>Save</button>";

        echo "</div>"; 
    }
} else {
    echo "<p>No flight offers found.</p>";
}

echo "<style>
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
</style>";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function saveFlight(offer, userID) {
    const firstItinerary = offer.itineraries[0];
    const firstSegment = firstItinerary.segments[0];

    $.ajax({
        url: '/flights/save_flight.php',
        type: 'POST',
        data: {
            airline: firstSegment.carrierCode,
            flightNumber: firstSegment.number,
            departureAirport: firstSegment.departure.iataCode,
            arrivalAirport: firstSegment.arrival.iataCode,
            departureDateTime: firstSegment.departure.at,
            arrivalDateTime: firstSegment.arrival.at,
            ticketPrice: offer.price.total,
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