<?php
include('flightapi.php');


// Initialize cURL session
$ch = curl_init();

$origin = $_POST['origin'] ?? 'NYC';
$destination = $_POST['destination'] ?? 'MAD';

// Change to the format that the API expects

$departureDateInput = $_POST['departureDate'];

$predepartureDate = DateTime::createFromFormat('d-m-Y', $departureDateInput);

if (!$predepartureDate) {
    echo "Invalid date format!";
} else {
    $departureDate = $predepartureDate->format('Y-m-d');
}



$returnDateInput = $_POST['returnDate'] ?? strtotime('+8 day');

$prereturnDate = DateTime::createFromFormat('d-m-Y', $returnDateInput);

if (!$prereturnDate) {
    echo "Invalid date format!";
} else {
    $returnDate = $prereturnDate->format('Y-m-d');
}

// Continue with the rest of the code

$adults = $_POST['adults'] ?? 1;

var_dump($origin, $destination, $departureDate, $returnDate, $adults);
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

        // Display price information
        echo "<h2>Price: " . $offer['price']['total'] . " " . $offer['price']['currency'] . "</h2>";

        // Display itinerary information
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

        echo "</div>"; // .flight-offer
    }
} else {
    echo "<p>No flight offers found.</p>";
}

echo "<style>
.flight-offer {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
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
</style>";
?>