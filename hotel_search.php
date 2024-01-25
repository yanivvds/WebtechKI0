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
    foreach ($responseArray['data'] as $hotel) {
        echo "<div class='hotel-offer'>";

        // Displaying the hotel name
        echo "<h2>Hotel Name: " . $hotel['name'] . "</h2>";

        // Assuming 'iataCode' represents the city
        echo "<p>City (IATA Code): " . $hotel['iataCode'] . "</p>";

        // Label associated to the location
        echo "<p>Info: " . $hotel['Location_Hotel']['name']  . "</p>";

        // Address information
        // Assuming the structure of 'address' is like what's shown in the 'Hotel' schema
        if (isset($hotel['address'])) {
            echo "<div class='hotel-details'>";
            echo "<p>Country Code: " . $hotel['address']['countryCode'] . "</p>";
            // Other address details would go here, if available
            echo "</div>"; // .hotel-details
        }

        // Rating information
        // The 'rating' isn't explicitly available in the data structure you've provided.
        // You might need to access a different API endpoint or part of the response for this.

        echo "</div>"; // .hotel-offer
    }
} else {
    echo "<p>No hotel offers found.</p>";
}
?>

</body>
</html>
