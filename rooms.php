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
    p {
    color: #fff;
    font-size: 20px;
    margin: 12px;
    }



    .backbtn{
    align-items: center;
    padding: 10px 20px;
    border: 0;
    outline: 0;
    border-radius: 5%;
    cursor: pointer;
    background-color: #986E43;
    color: #fff;
    font-size: 20px;
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
    .city-save-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    }

    .save-room-button {
        padding: 10px 20px;
        background-color: #4CAF50; 
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }

    .save-room-button:hover {
        background-color: #45a049; 
    }

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="css/stylesheet.css">
</head>
<body style="height: 100%; min-height: 100vh;">
<?php require_once("navbar.php"); ?>
    <?php
    
include('hotelapi.php');
if (isset($_GET['hotelId'])) {
    $hotelId = $_GET['hotelId'];
}

$checkInDate = $_GET['checkInDate'] ?? date('Y-m-d', strtotime('+1 day'));
$checkOutDate = $_GET['checkOutDate'] ?? date('Y-m-d', strtotime('+8 day'));
$adults = $_GET['adults'] ?? 1;
$cityCode = $_GET['cityCode'] ?? 'AMS';

$userID = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["user_id"])) {
        $userID = $_SESSION["user_id"];
    }
}

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

        if (isset($hotelOffer['offers']) && !empty($hotelOffer['offers'])) {
            foreach ($hotelOffer['offers'] as $offer) {
                echo "<div class='city-save-container'>";
                echo "<p><strong>City:</strong> " . htmlspecialchars($hotelOffer['hotel']['cityCode']) . "</p>";
                echo "</div>";
                echo "<div class='offer-details'>"; // Show all offer details
                echo "<p><strong>Check-in Date:</strong> " . htmlspecialchars($offer['checkInDate']) . "</p>"; 
                echo "<p><strong>Check-out Date:</strong> " . htmlspecialchars($offer['checkOutDate']) . "</p>"; 
                if (isset($typeEstimated['category'])) {
                    echo "<p><strong>Room Type:</strong> " . htmlspecialchars($typeEstimated['category']) . "</p>";
                } else {
                    echo "<p><strong>Room Type:</strong> Not specified</p>";
                }
                if (isset($offer['room']['typeEstimated'])) {
                    $typeEstimated = $offer['room']['typeEstimated'];
                    if (isset($typeEstimated['category'])) {
                        echo "<p><strong>Room Type:</strong> " . htmlspecialchars($typeEstimated['category']) . "</p>"; // Room Type
                    }
                    if (isset($typeEstimated['beds']) && isset($typeEstimated['bedType'])) {
                        echo "<p><strong>Bed Details:</strong> " . htmlspecialchars($typeEstimated['beds']) . " " . htmlspecialchars($typeEstimated['bedType']) . "(s)</p>"; // Bed details
                    }
                }
                echo "<p><strong>Room Description:</strong> " . htmlspecialchars($offer['room']['description']['text']) . "</p>"; // Room Description
                echo "<p><strong>Price total:</strong> " . htmlspecialchars($offer['price']['currency']) . " " . htmlspecialchars($offer['price']['total']) . "</p>"; // Price
                echo "<p><strong>Payment Type:</strong> " . htmlspecialchars($offer['policies']['paymentType']) . "</p>"; // Payment Type
                
                // Cancellation Policy
                if (isset($offer['policies']['cancellations']) && !empty($offer['policies']['cancellations'])) {
                    foreach ($offer['policies']['cancellations'] as $cancellation) {
                        echo "<div class='cancellation-policy'>";
                        if (isset($offer['policies']['cancellations']['deadline']) && !empty($offer['policies']['cancellations']['deadline'])) {
                            echo "<p><strong>Cancellation Deadline:</strong> " . htmlspecialchars($cancellation['deadline']) . "</p>"; }// Cancellation Deadline
                        if (isset($offer['policies']['cancellations']['amount']) && !empty($offer['policies']['cancellations']['amount'])) {
                        echo "<p><strong>Cancellation Fee:</strong> " . htmlspecialchars($cancellation['amount']) . "</p>"; } // Cancellation Fee
                        echo "</div>"; 
                    }
                }
                $offerJson = htmlspecialchars(json_encode($hotelOffer), ENT_QUOTES, 'UTF-8');
                echo "<button class='save-button' onclick='saveRoom($offerJson, $userID)'>Save</button>";    
                echo "</div>"; 
            }
        }
        
        echo "</div>"; // Close hotel-offer container
    }
    echo "</div>"; // Close hotel-offers-container
} else {
    echo "<h1 style='color: #e2d1c6;font-size: 250%;text-align: center;margin-top: 2%;'>No hotel offers found at this time.</h1>";
    echo "<p style='color: #efe9e6;font-size: 20px;text-align: center;'>Because we are still in a testing environment from this API not all hotel options will load.</p>";
    echo "<div style='text-align: center;margin-top: 2%;'>";
    echo "<a class='backbtn' href='hotel_search.php?bestemming=" . urlencode($cityCode) . "&checkInDate=" . urlencode($checkInDate) . "&checkOutDate=" . urlencode($checkOutDate) . "&adults=" . urlencode($adults) . "'>Go back</a>";
    echo "</div>";
}
?>
<script>


    function saveRoom(offer, userID) {
        if (userID === null) {
        alert('User is not logged in.');
        return;
        }

       // Extract relevant data from the offer JSON
        const hotelName = offer.hotel.name;
        const offerID = offer.offers[0].id;
        const checkInDate = offer.offers[0].checkInDate; // Assuming there's only one offer
        const checkOutDate = offer.offers[0].checkOutDate;
        const cityCode = offer.hotel.cityCode;
        const bedDetails = offer.offers[0].room.typeEstimated.beds + ' ' + offer.offers[0].room.typeEstimated.bedType;
        const roomDescription = offer.offers[0].room.description.text;
        const roomType = offer.offers[0].room.typeEstimated.category;
        const priceTotal = offer.offers[0].price.total;
        const currency = offer.offers[0].price.currency;
        const paymentType = offer.offers[0].policies.paymentType;
        const cancellationDeadline = offer.offers[0].policies.cancellations[0].deadline;
        const cancellationFee = offer.offers[0].policies.cancellations[0].amount;


        // Perform the AJAX POST request to save the room offer
        $.ajax({
            url: 'save_room.php',
            type: 'POST',
            data: {
                userID: userID,
                hotelName: hotelName,
                offerID: offerID,
                checkInDate: checkInDate,
                checkOutDate: checkOutDate,
                cityCode: cityCode,
                bedDetails: bedDetails,
                roomDescription: roomDescription,
                roomType: roomType,
                priceTotal: priceTotal,
                currency: currency,
                paymentType: paymentType,
                cancellationDeadline: cancellationDeadline,
                cancellationFee: cancellationFee
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Room saved successfully!');
                } else {
                    alert('Error saving room: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }
</script>
</body>
</html>