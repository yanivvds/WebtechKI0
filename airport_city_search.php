<?php
include('flights/flightapi.php');

$query = $_POST['search_query'] ?? '';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://test.api.amadeus.com/v1/reference-data/locations?subType=AIRPORT,CITY&keyword=$query");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$responseArray = json_decode($response, true);


curl_close($ch);


if (isset($responseArray['data']) && is_array($responseArray['data'])) {
    echo json_encode($responseArray['data']);
} else {
    echo json_encode();
}
?>
