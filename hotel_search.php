<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing HTML head content -->
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


// --- HOTEL KAMERS!! NIEUWE API --- //

$hotelOffersCh = curl_init();
$hotelOffersUrl = "https://test.api.amadeus.com/v3/shopping/hotel-offers?hotelIds=$hotelId&checkInDate=$checkInDate&checkOutDate=$checkOutDate&adults=$adults";

curl_setopt($hotelOffersCh, CURLOPT_URL, $hotelOffersUrl);
curl_setopt($hotelOffersCh, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/x-www-form-urlencoded'
));
curl_setopt($hotelOffersCh, CURLOPT_RETURNTRANSFER, true);

$hotelOffersResponse = curl_exec($hotelOffersCh);
$hotelOffersArray = json_decode($hotelOffersResponse, true);

curl_close($hotelOffersCh);

if (isset($responseArray['data']) && is_array($responseArray['data'])) {
    foreach ($responseArray['data'] as $hotel) {
        echo "<div class='hotel-offer'>";
        $hotelId = $hotel['hotelId']; // Store the hotelId for the second API call
        // Show the hotel name
        echo "<h2>Hotel Name: " . $hotel['name'] . "</h2>";

        // Show the city
        echo "<p>City: " . $hotel['iataCode'] . "</p>";
        if (isset($hotel['address'])) {
            echo "<div class='hotel-details'>";
            // and country
            echo "<p>Country: " . $hotel['address']['countryCode'] . "</p>";
            echo "</div>"; 
        }

        // Add a button to toggle collapsible content
        echo "<button class='toggle-button'>Toggle Room Details</button>";

        echo "</div>"; // .hotel-offer
    }
} else {
    echo "<p>No hotel offers found.</p>";
}
// Handling the response and displaying the hotel offers
if (isset($hotelOffersArray['data']) && is_array($hotelOffersArray['data'])) {
    foreach ($hotelOffersArray['data'] as $hotelOffer) {
        echo "<div class='room-offer'>";
        // Show the hotel name and other details
        echo "<h2>Hotel Name: " . $hotelOffer['hotel']['name'] . "</h2>";
        // ... Add more details as needed

        echo "<div class='room-type'>";
        if (isset($hotelOffer['offers'])) {
            foreach ($hotelOffer['offers'] as $offer) {
                // Display offer details, price, etc.
                echo "<p>Price: " . $offer['price']['total'] . " " . $offer['price']['currency'] . "</p>";
                // ... Add more offer details as needed
            }
        }
        echo "</div>"; // .room-type

        echo "<button class='book-button'>Save Now</button>";

        echo "</div>"; // .room-offer

        // JavaScript to toggle the collapsible content
        echo "<script>
                var toggleButton = document.querySelector('.toggle-button');
                toggleButton.addEventListener('click', function() {
                    var hotelOffer = toggleButton.closest('.room-offer');
                    var collapsibleContent = hotelOffer.querySelector('.collapsible-content');
                    if (collapsibleContent.style.display === 'none') {
                        collapsibleContent.style.display = 'block';
                    } else {
                        collapsibleContent.style.display = 'none';
                    }
                });
              </script>";
    }
} else {
    echo "<p>No hotel offers found.</p>";
}
?>
</body>
</html>
