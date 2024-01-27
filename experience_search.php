<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours and Activities</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <style>
        
    .activity-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .activity-offer {
        position: relative;
        background-size: cover;
        background-position: center;
        color: #fff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 10px;
        height: 400px; 
    }   
    .save-icon {
        position: absolute;
        top: -13px;
        right: 15px;
        width: 51px;
        height: 32px;
        cursor: pointer;
        background-size: cover;
    }



    .save-icon.empty {
        background-image: url('/fotos/bookmark-empty.svg'); 
    }

    .save-icon.filled {
        background-image: url('/fotos/bookmark.svg'); 
    }

    .activity-offer::before {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6); 
        border-radius: 10px;
    }

    .title-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .activity-offer * {
        position: relative;
        z-index: 1;
    }

    .activity-offer h2 {
        font-size: 1.5em;
        margin: 10px;
    }

    .short-description {
        margin: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    p {
        color: #fff;
        font-size: 20px;
        margin: 10px;
    }

    .full-description {
        max-height: 0;
        overflow-y: auto;
        transition: max-height 0.3s ease-in-out;
    }

    .read-more-button {
        align-self: center;
        margin-bottom: 10px;
        background-color: #b79079;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .activity-title {
        font-size: 1.5em;
        margin: 10px;
        flex-grow: 1;
    }

    .view-details-button {
        display: block;
        background-color: #986e43;
        color: white;
        padding: 10px 20px;
        text-align: center;
        width: 100%;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .view-details-button:hover {
        background-color: #ab7946;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="height: 100%;">
<?php require_once("navbar.php"); ?>
<?php
include('activitiesapi.php'); 

$latitude = $_POST['latitude'] ?? '41.390154'; // Default latitude
$longitude = $_POST['longitude'] ?? '2.173691'; // Default longitude
$radius = 4; // 4 km radius
$userID = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["user_id"])) {
        $userID = $_SESSION["user_id"];
    }
}

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
        if (!empty($activity['description'])) { 
            $backgroundImage = $activity['pictures'][0] ?? '';
            $shortDescription = substr($activity['description'], 0, 100) . '...'; 
            
            echo "<div class='activity-offer' style='background-image: url(\"$backgroundImage\");'>";
            echo "<div class='title-section'>";
                echo "<h2 class='activity-title' style='font-size: 1.5 rem; margin: 10px 35px 10px 10px;'>" . $activity['name'] .  "</h2>";
                echo "<div class='save-icon empty' style='position: absolute;right: 2px;top: 15px;width: 35px;' onclick='saveExperience(activityData, userID)'></div>";
            echo "</div>";
            echo "<p class='short-description'>$shortDescription</p>"; 
            echo "<button class='read-more-button'>Read More</button>";
            echo "<div class='full-description'><p>" . $activity['description'] . "</p></div>";
            echo "<p>Price: " . $activity['price']['amount'] . " " . $activity['price']['currencyCode'] . "</p>"; 
            echo "<a href='" . $activity['bookingLink'] . "' target='_blank' class='view-details-button'>Book Now</a>";
            echo "</div>"; 
        }
    }
} else {
    echo "<p>No activities found.</p>";
}
echo "</div>"; 
?>
<script>
    var userID = <?php echo isset($userID) ? $userID : 'null'; ?>;
    function saveExperience(activity, userID) {
        if (userID === null) {
            alert('User is not logged in.');
            return;
        }

        const activityName = activity.name;
        const activityDescription = activity.description;
        const activityPrice = activity.price.amount;
        const activityCurrency = activity.price.currencyCode;

        // Perform the AJAX POST request 
        $.ajax({
            url: 'save_experience.php',
            type: 'POST',
            data: {
                userID: userID,
                activityName: activityName,
                activityDescription: activityDescription,
                activityPrice: activityPrice,
                activityCurrency: activityCurrency,
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Experience saved successfully!');
                } else {
                    alert('Error saving experience: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.read-more-button').forEach(button => {
            button.onclick = function() {
                let fullDescription = this.parentNode.querySelector('.full-description');
                let shortDescription = this.parentNode.querySelector('.short-description');
                let isExpanded = fullDescription.style.maxHeight !== '0px';
                fullDescription.style.maxHeight = isExpanded ? '0px' : '500px'; 
                shortDescription.style.display = isExpanded ? 'block' : 'none';
                this.textContent = isExpanded ? 'Read More' : 'Show Less';
            };
        });

        document.querySelectorAll('.save-icon').forEach(icon => {
            icon.saved = false;
            icon.onclick = function() {
                const activityOffer = this.closest('.activity-offer'); // Get the closest parent '.activity-offer' element

                if (this.saved) {
                    this.classList.remove('filled');
                    this.classList.add('empty');
                    this.saved = false;
                    // Here, you may want to add code to remove the saved experience from the server using AJAX.
                } else {
                    this.classList.remove('empty');
                    this.classList.add('filled');
                    this.saved = true;

                    // Ensure that you are targeting the correct elements within the same '.activity-offer' container
                    const activityData = {
                        name: activityOffer.querySelector('.activity-title').textContent,
                        description: activityOffer.querySelector('.full-description p').textContent,
                        price: {
                            amount: parseFloat(activityOffer.querySelector('.activity-offer p:last-of-type').textContent.split(' ')[1]), // Assuming the price is in the last <p> tag within '.activity-offer'
                            currencyCode: activityOffer.querySelector('.activity-offer p:last-of-type').textContent.split(' ')[2] // Assuming the currency code is in the last <p> tag within '.activity-offer'
                        }
                    };

                    // Call the saveExperience function 
                    saveExperience(activityData, userID);
                }
            };
        });
    });
</script>

</body>
</html>
