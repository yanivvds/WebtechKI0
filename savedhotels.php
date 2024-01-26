<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Flights</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: normal;
        }

        tr:hover {
            background-color: #f2f2f2;
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
        
        .content {
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
            padding: 0 18px;
        }
    </style>
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <h2 style="text-align: center;">Your Saved Flights</h2>

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
            echo "<table>";
            echo "<tr>
                <th>Hotel name</th>
                <th>City code</th>
                <th>Check-in date</th>
                <th>Check-out date</th>
                <th>Room type/Time</th>
                <th>Bed type</th>
                <th>Room Description</th>
                <th>Price total</th>
                <th></th>
                <th></th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['HotelName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['CityCode']) . "</td>";
                echo "<td>" . htmlspecialchars($row['CheckInDate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['CheckOutDate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['RoomType']) . "</td>";
                echo "<td>" . htmlspecialchars($row['BedDetails']) . "</td>";
                echo "<td>€" . htmlspecialchars($row['RoomDescription']) . "</td>";
                echo "<td>" . htmlspecialchars($row['PriceTotal']) . "</td>";
                echo "<td>" . htmlspecialchars($row['currency']) . "</td>";
                echo "<td>
                        <form action='' method='post'>
                            <input type='hidden' name='remove_room_id' value='" . $row['RoomID'] . "'>
                            <input type='submit' class='remove-button' value='Remove'>
                        </form>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
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
    <a href="pastflights.php" class='btn'>View Past Flights</a>
    </div>
</body>
</html>
