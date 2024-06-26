<?php
// This file calls the city search API (which is needed for the Autocomplete in the form ), 
// the difference with this is that it also finds cities that dont have an airport.

include('flights/flightapi.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('MAX_REQUESTS', 10); // Max requests per 60s
define('TIME_WINDOW', 60);

// Initialise the session timer
if (!isset($_SESSION['request_count'])) {
    $_SESSION['request_count'] = 0;
    $_SESSION['start_time'] = time();
}

// Check if the time window has expired and reset the counter if it has
if (time() - $_SESSION['start_time'] > TIME_WINDOW) {
    $_SESSION['request_count'] = 0;
    $_SESSION['start_time'] = time();
}

// Increment the request count and check the rate limit
$_SESSION['request_count']++;


if ($_SESSION['request_count'] > MAX_REQUESTS) {
    http_response_code(429);
    echo json_encode(['error' => 'Rate limit exceeded. Please wait a moment before trying again.']);
    exit;
}

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
