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
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            width: 300px;
            overflow: hidden;
        }

        .card-header {
            background-color: #E3D1C5;
            color: #333;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
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
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<div class='card-header'>" . htmlspecialchars($row['Airline']) . " - " . htmlspecialchars($row['FlightNumber']) . "</div>";
                echo "<div class='card-body'>";
                echo "<p>Departure: " . htmlspecialchars($row['DepartureAirport']) . "</p>";
                echo "<p>Arrival: " . htmlspecialchars($row['ArrivalAirport']) . "</p>";
                echo "<p>Depart: " . htmlspecialchars($row['DepartureDateTime']) . "</p>";
                echo "<p>Arrive: " . htmlspecialchars($row['ArrivalDateTime']) . "</p>";
                echo "<p>Price: €" . htmlspecialchars($row['Ticketprice']) . "</p>";
                echo "<p>Layovers: " . htmlspecialchars($row['Layovers']) . "</p>";
                echo "</div>";
                echo "<div class='card-footer'>";
                echo "<form action='' method='post'>
                        <input type='hidden' name='remove_flight_id' value='" . $row['FlightID'] . "'>
                        <input type='submit' class='remove-button' value='Remove'>
                      </form>";
                echo "</div>";
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
