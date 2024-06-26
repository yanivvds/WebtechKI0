<?php
require_once 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    echo "<script>setTimeout(function(){ window.location.href = 'login.php'; });</script>";
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Search</title>
<link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
<link rel="stylesheet" href="/css/stylesheet.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
        .ui-autocomplete {
            background-color: #f0f0f0; /* Background color of the dropdown */
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .ui-menu-item {
            padding: 3px 15px;
            background-color: #f0f0f0; 
            color: #333; /* Text color */
        }

        .ui-menu-item:hover, .ui-menu-item.ui-state-focus {
            background-color: #d0d0d0; 
            color: #212121; /* Hover text color */
        }
    </style>
</head>
<body style="height: 100%;">
<?php require_once("navbar.php"); ?>
<div class="form-container" style="margin: 3%;text-align: -webkit-center;">
  <div class="formsignup">
    <div class="title">Flight Search</div>
    <form action="/flights/flightsearch.php" method="post">
        <div class="input-container ic1">
            <input id="origin" class="input" type="text" placeholder=" " name="origin" required/>
            <div class="cut"></div>
            <label for="origin" class="placeholder">Origin</label>
        </div>
        <div class="input-container ic2">
            <input id="destination" class="input" type="text" placeholder=" " name="destination" required/>
            <div class="cut"></div>
            <label for="destination" class="placeholder">Destination</label>
        </div>
        <div class="input-container ic1">
            <input id="departureDate" class="input" type="date" placeholder=" " name="departureDate" required/>
            <div class="cut"></div>
            <label for="departureDate" class="placeholder">Departure Date</label>
        </div>
        <div class="input-container ic2">
            <input id="returnDate" class="input" type="date" placeholder=" " name="returnDate" required/>
            <div class="cut cut-short"></div>
            <label for="returnDate" class="placeholder">Return Date</label>
        </div>
        <div class="input-container ic1">
            <input id="adults" class="input" type="number" placeholder=" " name="adults" required min="1" max="20"/>
            <div class="cut"></div>
            <label for="adults" class="placeholder">Number of adults</label>
        </div>
        <button type="submit" class="submit">Search Flights</button>
    </form>
  </div>
</div>
<script>
// This script is used to setup the autocomplete feature for the origin and destination fields 
// by using the IATA codes of the airports and cities.
$(document).ready(function() {
    function setupAutocomplete(selector) {
        $(selector).autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: '/airport_city_search.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        search_query: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.detailedName + ' (' + item.iataCode + ')',
                                value: item.iataCode 
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                event.preventDefault(); // To prevent the default behavior
                $(this).val(ui.item.value); 
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<div>" + item.label + "</div>") // Label
                .appendTo(ul);
        };
    }

    setupAutocomplete('#origin');
    setupAutocomplete('#destination');
});
</script>

</body>
</html>
