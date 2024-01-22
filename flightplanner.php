<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Search</title>
<link rel="stylesheet" href="/css/stylesheet.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body style="height: 100vh;">
<?php require_once("navbar.php"); ?>
<div class="form-container" style="margin: 5%;text-align: -webkit-center;">
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
            <input id="adults" class="input" type="number" placeholder=" " name="adults" required/>
            <div class="cut"></div>
            <label for="adults" class="placeholder">Number of adults</label>
        </div>
        <button type="submit" class="submit">Search Flights</button>
    </form>
  </div>
</div>
<script>
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
