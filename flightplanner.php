<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Search</title>
<link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body style="height: 100vh;">
<div class="form-container" style="margin: 5%;text-align: -webkit-center;">
  <div class="formsignup">
    <div class="title">Flight Search</div>
    <form action="/flights/flightapi.php" method="post">
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
</body>
</html>
