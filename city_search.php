<?php
// This file calls the city search API (which is needed for the Autocomplete in the form ), 
// the difference with this is that it also finds cities that dont have an airport.

include('flights/flightapi.php');

$query = $_POST['search_query'] ?? '';

// cURL-sessie initialiseren
$ch = curl_init();

// cURL-opties instellen
curl_setopt($ch, CURLOPT_URL, "https://test.api.amadeus.com/v1/reference-data/locations?keyword=$query&subType=CITY");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// cURL-verzoek uitvoeren
$response = curl_exec($ch);
$responseArray = json_decode($response, true);

curl_close($ch);

// Verwerken van het resultaat
if (isset($responseArray['data']) && is_array($responseArray['data'])) {
    echo json_encode($responseArray['data']);
} else {
    echo json_encode();
}
?>
