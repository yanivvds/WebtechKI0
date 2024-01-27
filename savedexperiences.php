<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Hotels</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
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
    .remove-button {
        top: -13px;
        right: 15px;
        width: 72px;
        height: 35px;
        cursor: pointer;
        background-size: cover;
        background-color: #f44336;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

        .remove-button:hover {
            background-color: #d32f2f;
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
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <h2 style="text-align: center;">Your Saved Experiences</h2>
    <div class="card-container">
    <?php
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
    if (!isset($_SESSION["user_id"])) {
        echo "<script>setTimeout(function(){ window.location.href = 'login.php'; });</script>";
        exit; 
    }

    include('../database.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove_experience_id'])) {
        $removeRoomID = $_POST['remove_experience_id'];
        
        $removeSql = "DELETE FROM UserActivity WHERE UserID = ? AND ActivityID = ?";
        if ($removeStmt = $mysqli->prepare($removeSql)) {
            $removeStmt->bind_param("ii", $_SESSION["user_id"], $removeRoomID);
            $removeStmt->execute();
            $removeStmt->close();
            echo "<p>Experience removed successfully.</p>";
        }
    }

    $userID = $_SESSION["user_id"];


    $sql = "SELECT f.*, uf.ActivityID AS UserActivityID FROM Experience f
        INNER JOIN UserActivity uf ON f.ActivityID = uf.ActivityID
        WHERE uf.UserID = ?";


    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $userID);

        $stmt->execute();

        $result = $stmt->get_result();

        echo '<div class="activity-container">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

            
            echo "<div class='activity-offer' style='background-image: url(\"$backgroundImage\");'>";
            echo "<div class='title-section'>";
            $backgroundImage = htmlspecialchars($row['ActivityPicture']);
            $shortDescription = substr(htmlspecialchars($row['ActivityDescription']), 0, 100) . '...'; 
                echo "<h2 class='activity-title' style='font-size: 1.5 rem; margin: 10px 16px 10px 10px;'>" . htmlspecialchars($row['ActivityName']) .  "</h2>";
                // $offerJson = htmlspecialchars(json_encode($activity), ENT_QUOTES, 'UTF-8');
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='remove_experience_id' value='" . $row['ActivityID'] . "'>";
                echo "<input type='submit' class='remove-button' value='Remove'>";
                echo "</form>";
            echo "</div>";
            echo "<p class='short-description'>$shortDescription</p>"; 
            echo "<button class='read-more-button'>Read More</button>";
            echo "<div class='full-description'><p>" . htmlspecialchars($row['ActivityDescription']) . "</p></div>";
            echo "<p>Price: " . htmlspecialchars($row['ActivityPrice']) . " " . htmlspecialchars($row['ActivityCurrency']) . "</p>"; 
            echo "<a href='" . htmlspecialchars($row['ActivityBookingLink']) . "' target='_blank' class='view-details-button'>Book Now</a>";
            echo "</div>"; 
            }
        } else {
            echo "<p style='text-align: center;'>No saved activities found.</p>";
        }
        
        echo "</div>";

        $stmt->close();
    } else {
        echo "<p>Error: " . $mysqli->error . "</p>";
    }


    $mysqli->close();
    ?>
    </div>
    <script>
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
    });
    </script>
</body>
</html>
