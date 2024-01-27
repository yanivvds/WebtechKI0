<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours and Activities</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <style>
    .activity-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
    }

    .activity-offer {
        border: 1px solid #ddd;
        background-color: #ffffff33;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: calc(33% - 20px);
    }

    .activity-details {
        background-color: #d5b29c;
        margin-top: 10px;
        padding: 10px;
        border-radius: 5px;
    }

    h2 {
        margin-top: 0;
    }
    p {
        color: #fff;
        font-size: 20px;
        margin: 12px;
    }

    .backbtn {
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="height: 100%; min-height: 100vh;">
    <?php require_once("navbar.php"); ?>
    <div class='activity-container'>
        <!-- Activities will be loaded here -->
    </div>
    
    <script>
        $(document).ready(function() {
            const latitude = $_POST['latitude'];
            const longitude = $_POST['longitude'];
            const radius = 4; // 4 km radius

            $.ajax({
                url: 'https://test.api.amadeus.com/v1/shopping/activities',
                type: 'GET',
                data: {
                    latitude: latitude,
                    longitude: longitude,
                    radius: radius
                },
                headers: {
                    'Authorization: Bearer ' . $access_token,

                },
                success: function(response) {
                    const activities = response.data;
                    activities.forEach(function(activity) {
                        const activityElement = `
                            <div class='activity-offer'>
                                <h2 style='color: #986e43;'>${activity.name}</h2>
                                <img src="${activity.pictures[0]}" alt="Activity Image" style="width:100%; border-radius: 5px;">
                                <div class='activity-details'>
                                    <p>${activity.description}</p>
                                    <p><strong>Price:</strong> ${activity.price.amount} ${activity.price.currencyCode}</p>
                                    <p><strong>Duration:</strong> ${activity.minimumDuration}</p>
                                    <a href="${activity.bookingLink}" target="_blank" class="backbtn">Book Now</a>
                                </div>
                            </div>
                        `;
                        $('.activity-container').append(activityElement);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
</body>
</html>
