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
        .return-button {
            background-color: #ffffff;
            color: black;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .return-button:hover {
            background-color: #f3f2ee;
        }
        .collapsible {
        cursor: pointer;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: #555;
            color: white;
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
        echo "<p 'text-align: center;'>You must be logged in to see your saved flights.</p>";
        echo "<script>setTimeout(function(){ window.location.href = 'login.php'; }, 3000);</script>";
        exit; 
    }

    include('../database.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove_flight_id'])) {
        $removeFlightID = $_POST['remove_flight_id'];
        
        $removeSql = "DELETE FROM UserFlights WHERE UserID = ? AND FlightID = ?";
        if ($removeStmt = $mysqli->prepare($removeSql)) {
            $removeStmt->bind_param("ii", $_SESSION["user_id"], $removeFlightID);
            $removeStmt->execute();
            $removeStmt->close();
            echo "<p>Flight removed successfully.</p>";
        }
    }

    $userID = $_SESSION["user_id"];


    $sql = "SELECT f.*, uf.FlightID AS UserFlightID FROM Flight f
        INNER JOIN UserFlights uf ON f.FlightID = uf.FlightID
        WHERE uf.UserID = ? AND f.DepartureDateTime > NOW()";


    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $userID);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                <th>Airline</th>
                <th>Flight Number</th>
                <th>Departure Airport</th>
                <th>Arrival Airport</th>
                <th>Departure Date/Time</th>
                <th>Arrival Date/Time</th>
                <th>Ticket Price</th>
                <th>Layovers</th>
                <th></th>
                <th></th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Airline']) . "</td>";
                echo "<td>" . htmlspecialchars($row['FlightNumber']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DepartureAirport']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ArrivalAirport']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DepartureDateTime']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ArrivalDateTime']) . "</td>";
                echo "<td>€" . htmlspecialchars($row['Ticketprice']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Layovers']) . "</td>";
                echo "<td>
                        <form action='' method='post'>
                            <input type='hidden' name='remove_flight_id' value='" . $row['FlightID'] . "'>
                            <input type='submit' class='remove-button' value='Remove'>
                        </form>
                      </td>";
                echo "<td><button type='button' class='return-button'>Return Details</button></td>";
                echo "</tr>";
                echo "<tr class='content'>"; // Inklapbare rij voor return flights
                echo "<td>" . htmlspecialchars($row['ReturnAirline']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ReturnFlightNumber']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ReturnDepartureAirport']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ReturnArrivalAirport']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ReturnDepartureDateTime']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ReturnArrivalDateTime']) . "</td>";
                echo "<td></td>"; 
                echo "<td>" . htmlspecialchars($row['ReturnLayovers']) . "</td>";
                echo "<td></td>";
                echo "<td></td>";
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



    <!-- Knop voor return flight -->
    <script>
    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.parentElement.parentElement.nextElementSibling;
            if (content.style.display === "table-row") {
                content.style.display = "none";
            } else {
                content.style.display = "table-row";
            }
        });
    }
    </script>   
</body>
</html>
