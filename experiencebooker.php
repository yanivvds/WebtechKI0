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
        .price-range-container {
        margin: 20px 0;
        padding: 10px 0;
        display: flex;
        flex-direction: column;
    }

    /* Style for price range display */
    .price-range-display {
        font-size: 14px;
        font-weight: bold;
        color: #555;
        margin-bottom: 4px;
        text-align: center;
        margin-bottom: 10px;
    }

    /* Style for the jQuery UI Slider */
    .ui-slider {
        position: relative;
        text-align: left;
    }

    .ui-slider .ui-slider-handle {
        position: absolute;
        z-index: 2;
        width: 1.2em;
        height: 1.2em;
        cursor: pointer;
        border: 1px solid #AAA;
        background: #FFF;
        border-radius: 50%;
        outline: none;
    }

    .ui-slider .ui-slider-range {
        position: absolute;
        z-index: 1;
        background: #337ab7;
        border-radius: 4px;
    }

    .ui-slider-horizontal {
        height: .8em;
    }

    .ui-slider-horizontal .ui-slider-handle {
        top: -.3em;
        margin-left: -.6em;
    }

    .ui-slider-horizontal .ui-slider-range {
        top: 0;
        height: 100%;
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
                <div class="cut"></div>
            <label for="cityname" class="placeholder">Bestemming</label>
            <input type="hidden" id="latitude" name="latitude" />
            <input type="hidden" id="longitude" name="longitude" />
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
            <div class="input-container ic1 price-range-container">
                <label for="amount" class="placeholder price-range-display" style="margin-top: -4%;">Price range:</label>
                <p id="amount" class="price-range-display" style="border: 0; color: #f6931f; font-weight: bold; padding-top: 10px;"></p>
                <div id="price-range-slider" style="margin-bottom: 20px;"></div> <!-- Slider will be inserted here -->
                <input type="hidden" id="minPrice" name="minPrice" />
                <input type="hidden" id="maxPrice" name="maxPrice" />
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
                        console.log("Data received from server:", data);
                        response($.map(data, function(item) {
                            var cityName = item.address.cityName; 
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
<script>
$(document).ready(function() {
    // ... your existing JavaScript code ...

    // Initialize Price Range Slider
    $("#price-range-slider").slider({
        range: true,
        min: 0,
        max: 5000,
        values: [0, 5000], // Default values
        slide: function(event, ui) {
            $("#amount").html("€" + ui.values[0] + " - €" + ui.values[1]);
            $("#minPrice").val(ui.values[0]);
            $("#maxPrice").val(ui.values[1]);
        }
    });

    // Set initial values
    $("#amount").html("€" + $("#price-range-slider").slider("values", 0) +
                      " - €" + $("#price-range-slider").slider("values", 1));
    $("#minPrice").val($("#price-range-slider").slider("values", 0));
    $("#maxPrice").val($("#price-range-slider").slider("values", 1));

    // ... your existing JavaScript code ...
});
</script>

</body>
</html>
