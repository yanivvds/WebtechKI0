<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
include('hotelapi.php');
if (isset($_GET['hotelId'])) {
    $hotelId = $_GET['hotelId'];
}

$checkInDate = $_GET['checkInDate'] ?? date('Y-m-d', strtotime('+1 day'));
$checkOutDate = $_GET['checkOutDate'] ?? date('Y-m-d', strtotime('+8 day'));
$adults = $_GET['adults'] ?? 1;

$hotelOffersCh = curl_init();
$hotelOffersUrl = "https://test.api.amadeus.com/v3/shopping/hotel-offers?hotelIds=$hotelId&checkInDate=$checkInDate&checkOutDate=$checkOutDate&adults=$adults";


curl_setopt($hotelOffersCh, CURLOPT_URL, $hotelOffersUrl);
curl_setopt($hotelOffersCh, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/x-www-form-urlencoded'
));
curl_setopt($hotelOffersCh, CURLOPT_RETURNTRANSFER, true);

$hotelOffersResponse = curl_exec($hotelOffersCh);
// TESTINGGGG
$httpcode = curl_getinfo($hotelOffersCh, CURLINFO_HTTP_CODE);
echo "HTTP status code: $httpcode <br>";

// Check if the response is not false and the status code is 200
if ($hotelOffersResponse !== false && $httpcode == 200) {
    echo "Raw response: <pre>" . htmlspecialchars($hotelOffersResponse) . "</pre>";
} else {
    echo "Error fetching data. Response: " . htmlspecialchars($hotelOffersResponse);
}
// TESTINGGGG

$hotelOffersArray = json_decode($hotelOffersResponse, true);

curl_close($hotelOffersCh);

$roomDetails = [];

// Check if the 'data'  exists in the hotel offers 
if (isset($hotelOffersArray['data']) && !empty($hotelOffersArray['data'])) {
    // Going through each hotel offer
    foreach ($hotelOffersArray['data'] as $hotelOffer) {
        // Check for 'offers' key 
        if (isset($hotelOffer['offers']) && !empty($hotelOffer['offers'])) {
            foreach ($hotelOffer['offers'] as $offer) {
                $offerDetails = [
                    'id' => $offer['id'] ?? '',
                    'checkInDate' => $offer['checkInDate'] ?? '',
                    'checkOutDate' => $offer['checkOutDate'] ?? '',
                    'roomType' => $offer['room']['type'] ?? '',
                    'roomDescription' => $offer['room']['description']['text'] ?? '',
                    'guests' => $offer['guests']['adults'] ?? '',
                    'price' => [
                        'currency' => $offer['price']['currency'] ?? '',
                        'base' => $offer['price']['base'] ?? '',
                        'total' => $offer['price']['total'] ?? '',
                    ],
                    'paymentType' => $offer['policies']['paymentType'] ?? '',
                    'cancellationPolicy' => $offer['policies']['cancellations'][0]['description']['text'] ?? '',
                ];
                
                // Add the current offer details to the room details array
                $roomDetails[] = $offerDetails;
            }
        }
    }
}




?>

</body>
</html>


