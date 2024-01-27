<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours and Activities</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <style>
        
    .activity-offer {
        position: relative;
        background-size: cover;
        background-position: center;
        color: #fff;
        overflow: hidden;
    }

    .activity-offer::before {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); 
    }

    .activity-offer * {
        position: relative;
        z-index: 1;
    }

    .short-description {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }

    .full-description {
        display: none;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
    }

    .read-more-button {
        background-color: #986e43;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: inline-block;
        margin-top: 10px;
    }

    .read-more-button:hover {
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
        $backgroundImage = $activity['picture'][0]; // Get the first picture
        $shortDescription = substr($activity['description'], 0, 100) . '...'; 
        $fullDescription = $activity['description'];
        echo "<div class='activity-offer' style='background-image: url(\"$backgroundImage\");'>";
        // Show the activity name and short description
        echo "<h2>Activity Name: " . $activity['name'] . "</h2>";
        echo "<p class='short-description'>Description: $shortDescription</p>"; 
        echo "<button class='read-more-button'>Read More</button>";
        echo "<div class='full-description'><p>" . $activity['description'] . "</p></div>";
        echo "<p>Price: " . $activity['price']['amount'] . " " . $activity['price']['currencyCode'] . "</p>"; 
        echo "<a href='" . $activity['bookingLink'] . "' target='_blank' class='view-details-button'>Book Now</a>";
        echo "</div>"; 
    }
} else {
    echo "<p>No activities found.</p>";
}
echo "</div>"; 

?>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.read-more-button').forEach(button => {
            button.onclick = function() {
                let fullDescription = this.nextElementSibling;
                let isExpanded = fullDescription.style.maxHeight !== '0px';
                fullDescription.style.maxHeight = isExpanded ? '0px' : '500px'; // Adjust '500px' as needed
                this.textContent = isExpanded ? 'Read More' : 'Show Less';
            };
        });
    });
</script>
</body>
</html>
