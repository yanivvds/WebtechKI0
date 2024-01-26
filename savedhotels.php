<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Flights</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <style>
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjust minmax() values as needed */
            gap: 20px; /* Space between cards */
            padding: 20px;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            width: 300px;
            overflow: hidden;
            height: 100%;
        }

        .card-header {
            background-color: #E3D1C5;
            color: #333;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 15px 15px 15px 15px;
        }

        .card-body {
            padding: 10px;
            line-height: 1.6;
            color: #333;
        }

        .card-footer {
            padding: 10px;
            text-align: right;
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
                echo "<div class='card'>";
            echo "<div class='card-header'>";
            echo "<h3>" . htmlspecialchars($row['HotelName']) . "</h3>";
            echo "</div>"; // Close card-header
            echo "<div class='card-body'>";
            echo "<p>Check-in: " . htmlspecialchars($row['CheckInDate']) . "</p>";
            echo "<p>Check-out: " . htmlspecialchars($row['CheckOutDate']) . "</p>";
            echo "<p>Room Type: " . htmlspecialchars($row['RoomType']) . "</p>";
            echo "<p>Bed Details: " . htmlspecialchars($row['BedDetails']) . "</p>";
            echo "<p>Description: €" . htmlspecialchars($row['RoomDescription']) . "</p>";
            echo "<p>Price: " . htmlspecialchars($row['Currency']) . " " . htmlspecialchars($row['PriceTotal']) . "</p>";
            echo "</div>"; // Close card-body
            echo "<div class='card-footer'>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='remove_room_id' value='" . $row['RoomID'] . "'>";
            echo "<input type='submit' class='remove-button' value='Remove'>";
            echo "</form>";
            echo "</div>"; // Close card-footer
            echo "</div>"; // Close card
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
    </div>
    <div style='text-align: center; margin-top: 2%;'>
    <a href="pastflights.php" class='btn'>View Past Hotel reservations.</a>
    </div>
</body>
</html>
