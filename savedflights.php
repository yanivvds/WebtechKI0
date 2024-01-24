<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Flights</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: #e2d1c68f;
        }
        th {
            background-color: #E3D1C5;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <h2>Your Saved Flights</h2>

    <?php
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
    if (!isset($_SESSION["user_id"])) {
        echo "<p>You must be logged in to see your saved flights.</p>";
        echo "<script>setTimeout(function(){ window.location.href = 'login.php'; }, 3000);</script>";
        exit; 
    }

    include('../database.php');


    $userID = $_SESSION["user_id"];


    $sql = "SELECT f.* FROM Flight f
            INNER JOIN UserFlights uf ON f.FlightID = uf.FlightID
            WHERE uf.UserID = ?";

    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $userID);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Airline</th><th>Flight Number</th><th>Departure Airport</th><th>Arrival Airport</th><th>Departure Date/Time</th><th>Arrival Date/Time</th><th>Ticket Price</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Airline']) . "</td>";
                echo "<td>" . htmlspecialchars($row['FlightNumber']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DepartureAirport']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ArrivalAirport']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DepartureDateTime']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ArrivalDateTime']) . "</td>";
                echo "<td>€" . htmlspecialchars($row['Ticketprice']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No saved flights found.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error: " . $mysqli->error . "</p>";
    }


    $mysqli->close();
    ?>
</body>
</html>
