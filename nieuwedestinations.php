<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Destinations</title>
    <link rel="stylesheet" href="/css/stylesheet.css"> 
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">

</head>
<body style="background: #f6ede3;">
<div>
<?php require_once("navbar.php"); ?>
</div>
<div class="title">
    <h1 style="text-align: center; color: #f2e5d8; margin: 0em 1em; padding: 0 1em; font-size: 49px;"> Destinations </h1>
    <p style="max-width: 500px; margin: 1rem auto; line-height: 27px; color: #e0b287; text-align: center;">Click on the pins to see the destinations</p>
</div>
<div class="world-map">
    <img src="/fotos/nieuwewereld.png" alt="wereldkaart" />
    <div class="pin europe">
        <span><a href="europe.php" style="color: #7c5833;text-decoration: none;font-family: 'Poppins';">Europe</a></span>
    </div>
    <div class="pin asia">
        <span><a href="asia.php" style="color: #7c5833;text-decoration: none;font-family: 'Poppins';">>Asia</a></span>
    </div>
    <div class="pin oceania">
        <span><a href="oceania.php" style="color: #7c5833;text-decoration: none;font-family: 'Poppins';">>Oceania</a></span>
    </div>
    <div class="pin central-america">
        <span><a href="centralamerica.php" style="color: #7c5833;text-decoration: none;font-family: 'Poppins';">>Central America</a></span>
    </div>
</div>
<div style="z-index: 10;min-height: 0%;margin-top: 42%;position: absolute;bottom: 0;left: 0;width: 100%;position: relative;flex: 1;">
        <?php require_once("footer.php"); ?>
</div>
</body>
</html>