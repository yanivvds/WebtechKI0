<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Search</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f4f4f4;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.hotel-offers-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    justify-content: center;
}

.hotel-offer {
    background: #ffffff;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: calc(33% - 20px); /* Adjust the width as per your design */
    margin-bottom: 20px; /* Space between rows */
}

.hotel-offer h2 {
    margin-top: 0;
    color: #333333;
    font-size: 24px;
}

.hotel-details {
    background-color: #f9f9f9;
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
}

.view-rooms-button {
    background-color: #0056b3;
    color: white;
    padding: 10px 20px;
    text-align: center;
    display: block;
    width: 100%;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
    text-decoration: none;
}

.view-rooms-button:hover {
    background-color: #003d7a;
}

    </style>
</head>
<body style="height: 100%;">
<?php require_once("navbar.php"); ?>
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

echo '<div class="hotel-offers-container">';

if (isset($responseArray['data']) && is_array($responseArray['data'])) {
    foreach ($responseArray['data'] as $hotel) {
        echo "<div class='hotel-offer'>";
        // Show the hotel name
        echo "<h2>Hotel Name: " . $hotel['name'] . "</h2>";

        // Show the city
        echo "<p>City: " . $hotel['iataCode'] . "</p>"; 
        $hotelId = $hotel['hotelId'];
        if (isset($hotel['address'])) {
            echo "<div class='hotel-details'>";
            // and country
            echo "<p>Country: " . $hotel['address']['countryCode'] . "</p>"; 
            echo "</div>"; 
        }

        // View the rooms button
        echo "<button class='view-rooms-button' data-hotel-id='{$hotel['hotelId']}'>View Rooms</button>";


        echo "</div>"; // .hotel-offer
    }
} else {
    echo "<p>No hotel offers found.</p>";
}
echo "</div>"; 

echo "<script>
var viewRoomsButtons = document.querySelectorAll('.view-rooms-button');
viewRoomsButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var hotelId = button.getAttribute('data-hotel-id');
        window.location.href = 'rooms.php?hotelId=' + hotelId +
                               '&checkInDate=" . urlencode($checkInDate) .
                               "&checkOutDate=" . urlencode($checkOutDate) .
                               "&adults=" . urlencode($adults) . "';
    });
});
</script>";
    
    

?>
</body>
</html>
