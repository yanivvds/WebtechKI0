<?php
    require_once 'config.php';
?>

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
    <h1 style="text-align: center; color: #986e43 margin: 0em 1em; padding: 0 1em; font-size: 49px;"> Destinations </h1>
    <p style="max-width: 500px; margin: 1rem auto; line-height: 27px; color: #e0b287; text-align: center;">Click on the pins to see the destinations</p>
</div>
<div class="world-map">
    <img src="/wereld/wereld.png" alt="wereldkaart" />
    <div class="pin guatemala">
        <span style="left: -7.5rem;">Guatemala</span>
    </div>
    <div class="pin costa-rica">
        <span>Costa Rica</span>
    </div>
    <a data-target="australia" href="artikel.php"><div class="pin australia">
        <span data-content-id="australia">Australia</span>
    </div></a>
    <a data-target="italy"><div class="pin italy">
        <span data-content-id="italy">Italy</span>
    </div></a>
    <a data-target="portugal"><div class="pin portugal">
        <span data-content-id="portugal" style="left: -6rem;">Portugal</span>
    </div></a>
    <a data-target="noorwegen"><div class="pin norway">
        <span data-content-id="noorwegen">Norway</span>
    </div></a>
    <a data-target="usa"><div class="pin usa">
        <span data-content-id="usa">usa</span>
    </div></a>
    <a data-target="belize"><div class="pin belize">
        <span data-content-id="belize">Belize</span>
    </div></a>
    <a data-target="iceland"><div class="pin iceland">
        <span data-content-id="iceland" style="left: -5.5rem">Iceland</span>
    </div></a>
</div>
<div style="z-index: 10;min-height: 0%;margin-top: 42%;position: absolute;bottom: 0;left: 0;width: 100%;position: relative;flex: 1;">
        <?php require_once("footer.php"); ?>
</div>
</body>
</html>