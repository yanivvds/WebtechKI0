<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .hotel-offers-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
    }

    .hotel-offer {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: calc(33% - 20px);
    }

    .offer-details {
        background-color: #e2d0c5;
        margin-top: 10px;
        padding: 10px;
        border-radius: 5px;
    }

    h2 {
        margin-top: 0;
    }


</style>
<link rel="stylesheet" href="css/stylesheet.css">
</head>
<body style="height: 100%;">
<?php require_once("navbar.php"); ?>
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

$hotelOffersArray = json_decode($hotelOffersResponse, true);

curl_close($hotelOffersCh);

$roomDetails = [];

if (isset($hotelOffersArray['data']) && !empty($hotelOffersArray['data'])) {
    echo "<div class='hotel-offers-container'>"; // Container for all hotel offers
    foreach ($hotelOffersArray['data'] as $hotelOffer) {
        echo "<div class='hotel-offer'>"; // Individual hotel offer container
        
        echo "<h2 style='color: #986e43;'>" . htmlspecialchars($hotelOffer['hotel']['name']) . "</h2>"; 
        echo "<p><strong>City:</strong> " . htmlspecialchars($hotelOffer['hotel']['cityCode']) . "</p>";
        
        
        if (isset($hotelOffer['offers']) && !empty($hotelOffer['offers'])) {
            foreach ($hotelOffer['offers'] as $offer) {
                echo "<div class='offer-details'>"; // Show all offer details
                echo "<p><strong>Check-in Date:</strong> " . htmlspecialchars($offer['checkInDate']) . "</p>"; 
                echo "<p><strong>Check-out Date:</strong> " . htmlspecialchars($offer['checkOutDate']) . "</p>"; 
                echo "<p><strong>Room Type:</strong> " . htmlspecialchars($offer['room']['typeEstimated']['category']) . "</p>"; // Room Type
                if (isset($offer['room']['typeEstimated'])) {
                    $typeEstimated = $offer['room']['typeEstimated'];}
                if (isset($typeEstimated['beds']) && isset($typeEstimated['bedType'])) {
                    echo "<p><strong>Bed Details:</strong> " . htmlspecialchars($typeEstimated['beds']) . " " . htmlspecialchars($typeEstimated['bedType']) . "(s)</p>";} // Bed details
                echo "<p><strong>Room Description:</strong> " . htmlspecialchars($offer['room']['description']['text']) . "</p>"; // Room Description
                echo "<p><strong>Price total:</strong> " . htmlspecialchars($offer['price']['currency']) . " " . htmlspecialchars($offer['price']['total']) . "</p>"; // Price
                echo "<p><strong>Payment Type:</strong> " . htmlspecialchars($offer['policies']['paymentType']) . "</p>"; // Payment Type
                
                // Cancellation Policy
                if (isset($offer['policies']['cancellations']) && !empty($offer['policies']['cancellations'])) {
                    foreach ($offer['policies']['cancellations'] as $cancellation) {
                        echo "<div class='cancellation-policy'>";
                        echo "<p><strong>Cancellation Deadline:</strong> " . htmlspecialchars($cancellation['deadline']) . "</p>"; // Cancellation Deadline
                        echo "<p><strong>Cancellation Fee:</strong> " . htmlspecialchars($cancellation['amount']) . "</p>"; // Cancellation Fee
                        echo "</div>"; 
                    }
                }

                echo "</div>"; 
            }
        }
        
        echo "</div>"; // Close hotel-offer container
    }
    echo "</div>"; // Close hotel-offers-container
} else {
    echo "<h1 style='color: #e2d1c6;font-size: 250%;text-align: center;margin-top: 2%;'>No hotel offers found at this time.</h1>";
    echo "<p style='color: #efe9e6;font-size: 20px;text-align: center;'>Because we are still in a testing environment from this API not all hotel options will load.</p>";
    echo "<btn class:'btn'><a href='hotel_search.php" . "?bestemming=" . $cityCode . "&checkInDate=" . $checkInDate . "&checkOutDate=" . $checkOutDate . "&adults=" . $adults . "'>Go back</a></btn>";
}
?>

</body>
</html>