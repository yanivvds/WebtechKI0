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
    /* Add your autocomplete styles here */
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
                <label for="datumVan" class="placeholder">Datum van</label>
            </div>
            <div class="input-container ic1">
                <input id="datumTot" class="input" type="date" placeholder=" " name="datumTot" required/>
                <div class="cut cut-short"></div>
                <label for="datumTot" class="placeholder">Datum tot</label>
            </div>
            <div class="input-container ic1">
                <input id="aantalPersonen" class="input" type="number" placeholder=" " name="aantalPersonen" required/>
                <div class="cut"></div>
                <label for="aantalPersonen" class="placeholder">Aantal personen</label>
            </div>
            <button type="submit" class="submit">Search Hotels</button>
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
                        search_query: request.term,
                        subType: 'CITY' 
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.detailedName, // or item.name based on your preference
                                value: item.detailedName // or item.name based on your preference
                            };
                        }));
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

    setupAutocomplete('#origin');
    setupAutocomplete('#destination');
});

</script>
</body>
</html>