<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KZSGMBFN');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Insider</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
    <link href="css/stylesheet.css" rel="stylesheet">
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZSGMBFN"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php require_once("navbar.php"); ?>

        <div class="row">
            <div class="col" id="textfrontpage">
                <h1>Explore<br>The world</h2>
                <p>From mountain tops to white beaches, every country has its own unique charm</p>
                <p>waiting to be explored.</p>
                <button class="btn" id="explorebtn">Explore</button>
            </div>
            <div class="col">
                <div class="card card1">
                    <h5>Central America</h5>
                    <p>Pristine white beaches, azure waters, vibrant culture and delicious food</p>
                </div>
                <div class="card card2">
                    <h5>Europe</h5>
                    <p>Explore the captivating blend of ancient charm and modern 
                    allure in Europe, where iconic landmarks, diverse cuisines, and picturesque landscapes await. </p>
                </div>
                <div class="card card3">
                    <h5>Oceania</h5>
                    <p>Pristine beaches, lush rainforests, and vibrant cities seamlessly blending natural beauty with urban sophistication.</p>
                </div>
                <div class="card card4">
                    <h5>Asia</h5>
                    <p>Explore Asia's allure: ancient wonders, modern marvels, and a tapestry of cultures. From Japan's serene temples to Bali's tropical paradise, Asia invites you to a world of adventure and enchantment.</p>
                </div>
        </div>
    <script src="/javascript/script1.js"></script>
    <?php /* require_once("footer.php");  */?>

</body>
</html>