<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours and Activities</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <style>
        // ... (keep the same CSS styles you have for hotel-offer)
        .activity-offer {
            background: #f3eae0;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: calc(33% - 20px);
            margin-bottom: 20px; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .activity-offer h2 {
            margin-top: 0;
            color: #333333;
            font-size: 24px;
        }

        .view-details-button {
            background-color: #986e43;
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

        .view-details-button:hover {
            background-color: #ab7946;
        }
    </style>
</head>
<body style="height: 100%;">
<?php require_once("navbar.php"); ?>
<?php
include('activitiesapi.php'); 

$latitude = $_POST['latitude'] ?? '41.390154'; // Default latitude
$longitude = $_POST['longitude'] ?? '2.173691'; // Default longitude
$radius = 4; // 4 km radius

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://test.api.amadeus.com/v1/shopping/activities?latitude=$latitude&longitude=$longitude&radius=$radius");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/x-www-form-urlencoded'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$responseArray = json_decode($response, true);

curl_close($ch);

echo '<div class="activity-container">';

if (isset($responseArray['data']) && is_array($responseArray['data'])) {
    foreach ($responseArray['data'] as $activity) {
        echo "<div class='activity-offer'>";
        // Show the activity name
        echo "<h2 style='color: #986e43;'>Activity Name: " . $activity['name'] . "</h2>";
        echo "<p>Description: " . $activity['description'] . "</p>"; 
        echo "<p>Price: " . $activity['price']['amount'] . " " . $activity['price']['currencyCode'] . "</p>"; 
        echo "<a href='" . $activity['bookingLink'] . "' target='_blank' class='view-details-button'>Book Now</a>";

        echo "</div>"; // .activity-offer
    }
} else {
    echo "<p>No activities found.</p>";
}
echo "</div>"; 

?>
</body>
</html>
