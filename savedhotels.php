<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Flights</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <style>
        .hotel-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            transition: transform 0.2s; /* Animation */
        }

        .hotel-card:hover {
            transform: scale(1.03); /* Slight zoom on hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .hotel-card h3 {
            margin-top: 0;
            color: #007bff;
        }

        .hotel-card p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .hotel-card .remove-button {
            width: 100%;
            text-align: center;
            padding: 10px;
            font-size: 16px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <h2 style="text-align: center;">Your Saved Hotels</h2>

    <?php
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
    if (!isset($_SESSION["user_id"])) {
        echo "<script>setTimeout(function(){ window.location.href = 'login.php'; });</script>";
        exit; 
    }

    include('../database.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove_room_id'])) {
        $removeRoomID = $_POST['remove_room_id'];
        
        $removeSql = "DELETE FROM UserRooms WHERE UserID = ? AND RoomID = ?";
        if ($removeStmt = $mysqli->prepare($removeSql)) {
            $removeStmt->bind_param("ii", $_SESSION["user_id"], $removeFlightID);
            $removeStmt->execute();
            $removeStmt->close();
            echo "<p>Room removed successfully.</p>";
        }
    }

    $userID = $_SESSION["user_id"];


    $sql = "SELECT f.*, uf.RoomID AS UserRoomID FROM HotelRoom f
        INNER JOIN UserRooms uf ON f.RoomID = uf.RoomID
        WHERE uf.UserID = ? AND f.CheckInDate > NOW()";


    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $userID);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='hotel-card'>";
                echo "<h3>" . htmlspecialchars($row['HotelName']) . " - " . htmlspecialchars($row['CityCode']) . "</h3>";
                echo "<p>Check-in: " . htmlspecialchars($row['CheckInDate']) . "</p>";
                echo "<p>Check-out: " . htmlspecialchars($row['CheckOutDate']) . "</p>";
                echo "<p>Room Type: " . htmlspecialchars($row['RoomType']) . "</p>";
                echo "<p>Bed Details: " . htmlspecialchars($row['BedDetails']) . "</p>";
                echo "<p>Description: €" . htmlspecialchars($row['RoomDescription']) . "</p>";
                echo "<p>Price: " . htmlspecialchars($row['PriceTotal']) . " " . htmlspecialchars($row['PriceTotal']) . "</p>";
                echo "<form action='' method='post'>
                        <input type='hidden' name='remove_room_id' value='" . $row['RoomID'] . "'>
                        <input type='submit' class='remove-button' value='Remove'>
                      </form>";
                echo "</div>";
            }
        } else {
            echo "<p style='text-align: center;'>No saved flights found.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error: " . $mysqli->error . "</p>";
    }


    $mysqli->close();
    ?>
    <div style='text-align: center; margin-top: 2%;'>
    <a href="pastflights.php" class='btn'>View Past Hotel reservations.</a>
    </div>
</body>
</html>
