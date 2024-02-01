<!DOCTYPE html>
<html lang="en">
<!-- This file displays all flights of which the departure time has past. -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Hotels</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <style>
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjust minmax() values as needed */
            gap: 20px; /* Space between cards */
            padding: 20px;
            justify-content: center;
        }
        .card p {
            text-shadow: 0 0 5px #000;
            font-size: 15px;
            margin: 12px;
        }

        .card {
            background-color: #704b448c;
            border: 1px solid #986e43;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            width: 300px;
            overflow: hidden;
            height: 100%;
        }

        .card-header h3 {
            color: #986e43;
            font-size: 23px;
            font-weight: 550;
            text-shadow: 0.6px 0.6px rgba(255, 255, 255, 0.383);
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
            text-align: center;
        }


        .remove-button {
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
    </style>
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <h2 style="text-align: center;">Your Past Hotels</h2>
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
            $removeStmt->bind_param("ii", $_SESSION["user_id"], $removeRoomID);
            $removeStmt->execute();
            $removeStmt->close();
            echo "<p>Room removed successfully.</p>";
        }
    }

    $userID = $_SESSION["user_id"];


    $sql = "SELECT f.*, uf.RoomID AS UserRoomID FROM HotelRoom f
        INNER JOIN UserRooms uf ON f.RoomID = uf.RoomID
        WHERE uf.UserID = ? AND f.CheckInDate <= NOW()";


    
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
            echo "<p style='text-align: center;'>No Past Rooms found.</p>";
        }
        

        $stmt->close();
    } else {
        echo "<p>Error: " . $mysqli->error . "</p>";
    }


    $mysqli->close();
    ?>
    </div>
    <div style='text-align: center; margin-top: 2%;margin-bottom: 15%;'>
    <a href="savedhotels.php" class='btn'>View Saved Hotel reservations.</a>
    </div>
</body>
</html>
