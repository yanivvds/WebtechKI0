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
<title>Experience booker</title>
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
        <div class="title">Book your experience!</div>
        <form action="/experience_search.php" method="post">
            <div class="input-container ic1">
            <input id="cityName" class="input" type="text" placeholder=" " name="cityName" required/>
            <label for="cityname" class="placeholder">Bestemming</label>
                <div class="cut"></div>
                
            </div>
            <div class="input-container ic1">
                <input id="date" class="input" type="date" placeholder=" " name="date" required/>
                <div class="cut"></div>
                <label for="date" class="placeholder">Date</label>
            </div>
            <div class="input-container ic1">
                <input id="adults" class="input" type="number" placeholder=" " name="adults" required/>
                <div class="cut"></div>
                <label for="adults" class="placeholder">Adults</label>
            </div>
            <button type="submit" class="submit">Search Experiences</button>
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
                    url: '/city_search.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        search_query: request.term
                    },
                    success: function(data) {
                        response($.map(data.data, function(item) {
                            var cityName = item.name;
                            var cityLat = item.geoCode.latitude;
                            var cityLng = item.geoCode.longitude;
                            if (!uniqueCities.has(cityName)) {
                                uniqueCities.add(cityName);
                                return {
                                    label: cityName, 
                                    value: cityName,
                                    lat: cityLat,
                                    lng: cityLng
                                };
                            }
                        }));
                    }
                });
            },
            select: function(event, ui) {
                event.preventDefault();
                $("#cityName").val(ui.item.label);
                $("#latitude").val(ui.item.lat);
                $("#longitude").val(ui.item.lng);
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<div>" + item.label + "</div>")
                .appendTo(ul);
        };
    }

    setupCityAutocomplete('#cityName');
});
</script>
</body>
</html>