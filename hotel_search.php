<?php
include('hotelapi.php');

$query = $_POST['search_query'] ?? '';

$ch = curl_init();


$cityCode = $_POST['cityCode'] ?? 'PAR';
$checkInDate = $_POST['checkInDate'] ?? date('Y-m-d', strtotime('+1 day'));
$checkOutDate = $_POST['checkOutDate'] ?? date('Y-m-d', strtotime('+8 day'));
$adults = $_POST['adults'] ?? 1;


curl_setopt($ch, CURLOPT_URL, "https://test.api.amadeus.com/v1/reference-data/locations/hotels/by-city?cityCode=$cityCode");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/x-www-form-urlencoded'
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
