<?php
require_once 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    echo "<p>You must be logged in to book a hotel.</p>";
    echo "<script>setTimeout(function(){ window.location.href = 'login.php'; }, 3000);</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotel Bookings</title>
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
<body style="height: 100vh;">
<?php require_once("navbar.php"); ?>
<div class="form-container" style="margin: 3%;text-align: -webkit-center;">
    <div class="formsignup">
        <div class="title">Book hotel</div>
        <form action="/hotel_search.php" method="post">
            <div class="input-container ic1">
                <input id="bestemming" class="input" type="text" placeholder=" " name="bestemming" required/>
                <div class="cut"></div>
                <label for="bestemming" class="placeholder">Bestemming</label>
            </div>
            <div class="input-container ic1">
                <input id="datumVan" class="input" type="date" placeholder=" " name="datumVan" required/>
                <div class="cut"></div>
                <label for="datumVan" class="placeholder">Arrival</label>
            </div>
            <div class="input-container ic1">
                <input id="datumTot" class="input" type="date" placeholder=" " name="datumTot" required/>
                <div class="cut cut-short"></div>
                <label for="datumTot" class="placeholder">Departure</label>
            </div>
            <div class="input-container ic1">
                <input id="aantalPersonen" class="input" type="number" placeholder=" " name="aantalPersonen" required/>
                <div class="cut"></div>
                <label for="aantalPersonen" class="placeholder">Adults</label>
            </div>
            <button type="submit" class="submit">Search Hotels</button>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    function setupCityAutocomplete(selector) {
        $(selector).autocomplete({
            minLength: 2,
            source: function(request, response) {
                var uniqueCities = new Set();
                $.ajax({
                    url: '/airport_city_search.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        search_query: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            var cityName = item.address.cityName;
                            var cityCode = item.address.cityCode;
                            if (!uniqueCities.has(cityName)) { 
                                uniqueCities.add(cityName);
                                return {
                                    label: cityName, 
                                    value: cityCode  
                                };
                            }
                        }));
                        response(filteredData);
                    }
                });
            },
            select: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item.value);
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<div>" + item.label + "</div>") 
                .appendTo(ul);
        };
    }

    setupCityAutocomplete('#bestemming');
});
</script>
</body>
</html>
