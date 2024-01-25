<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel search</title>
    <style>
        .hotel-offer {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    position: relative; /* Add this to position the Save button */
}

.hotel-details {
    margin-top: 10px;
    padding: 5px;
    background-color: #f9f9f9;
}

.room-type {
    padding: 5px;
    border-top: 1px solid #eee;
}

.book-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #28a745;
    color: #fff;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
}

.book-button:hover {
    background-color: #218838;
}
.body {
    background-color: #f9f9f9;
}
    </style>
</head>
<body>
<?php
include('hotelapi.php');

$query = $_POST['search_query'] ?? '';

$ch = curl_init();


$cityCode = $_POST['bestemming'] ?? 'PAR';
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

foreach ($responseArray['data'] as $hotel) {
    // Display hotel details
    echo '<div class="hotel-offer">';
    echo '<div class="hotel-details">';
    // ... Display details like hotel name, location, etc.
    echo '</div>';
    foreach ($hotel['rooms'] as $room) {
        echo '<div class="room-type">';
        // ... Display room details
        echo '</div>';
    }
    echo '<button class="book-button">Save Room</button>';
    echo '</div>';
?>

</body>
</html>
