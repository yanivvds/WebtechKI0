<?php
require_once 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Insider</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
    <link rel="stylesheet" href="/css/stylemainpage.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation bar -->
    <?php require_once("navbar.php"); ?>
    <!-- picture with title -->
    <div class="fotodiv1">
        <h1>Explore The World</h2>
        <p>Discover a world of travel possibilities, where every page unfolds new <br>adventures and valuable insights</p>
    </div>
    <!-- Section with cards of different destinations -->
    <div class="golfpagina1">
        <h3 style="margin-top:-27rem;">Explore</h3>
    <div class="cool">
        <a href="centralamerica.php"><div class="caard card--1">
            <h5>Central America</h5>
            <p>Pristine white beaches, azure waters, vibrant culture and delicious food</p>
        </div></a>
        <a href="europe.php"><div class="caard card--2">
            <h5>Europe</h5>
            <p>Explore the captivating blend of ancient charm and modern 
            allure in Europe, where iconic landmarks, diverse cuisines, and picturesque landscapes await. </p>
        </div></a>
        <a href="oceania.php"><div class="caard card--3">
            <h5>Oceania</h5>
            <p>Pristine beaches, lush rainforests, and vibrant cities seamlessly blending natural beauty with urban sophistication.</p>
        </div></a>
        <a href="asia.php"><div class="caard card--4">
            <h5>Asia</h5>
            <p>Discover Asia's charm: ancient wonders, modern sights, and rich cultures. From Japan's tranquil temples to Bali's lush beauty, experience an enchanting adventure.</p>
        </div></a>
    </div>
    </div>
    <!-- Section about cappadocia -->
    <div class="test">
        <h3>Enchanting Cappadocia</h3>
        <p>Where Magic Awakens Beneath the Rocks</p>
        <a href="inspiration.php"><button class="exploreknop">Explore</button></a>
        
    </div>
    <!-- section with gallery about different roadtrips -->
    <div class="golfpagina2">
        <div class="title3"><h3>Take the road</h3></div>
        <div class="gallery">
            <div class="gallery__item gallery__item--1">
                <a href="#">
                    <div class="imagediv--1">
                        <h5>Amalfi Coast</h5>
                        <p class="hide1">Central Italy, renowned for its scenic landscapes, historic architecture, and world-class vineyards</p>
                    </div>
                    </a>
            </div>
            <div class="gallery__item gallery__item--2">
                <a href="#">
                    <div class="imagediv--2">
                        <h5>Eastern Australia</h5>
                        <p>Embark on an unforgettable road trip through Eastern Australia, where stunning coastlines, diverse landscapes, and vibrant cities create a captivating journey of exploration and adventure</p>
                    </div>
                    </a>
            </div>
            <div class="gallery__item gallery__item--3">
                <a href="#">
                    <div class="imagediv--3" alt="Image 3">
                        <h5>Route 66</h5>
                        <p>Embark on the iconic Route 66 road trip, traversing through the heart of America, where historic roadside attractions, classic diners, and the open road converge to create an enduring journey filled with nostalgia and Americana charm</p>
                    </div>
                </a>
            </div>
            <div class="gallery__item gallery__item--4">
                <a href="#">
                    <div class="imagediv--4">
                        <h5>Iceland</h5>
                        <p>Embark on a road trip through the otherworldly landscapes of Iceland, where cascading waterfalls, volcanic terrain, and vast glaciers paint an ethereal and breathtaking journey through the land of fire and ice</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div style="z-index: 10;min-height: 0%;margin-top: 42%;position: absolute;bottom: 0;left: 0;width: 100%;position: relative;flex: 1;"> 
       <!-- insert footer --> 
        <?php require_once("footer.php"); ?>
    </div>
    <!-- cookie pop-up -->
    <div id="cookies">
        <div class="containercook">
            <div class="subcontainer">
                <div class="cookies">
                    <p>This website uses cookies to ensure you get the best experience on our website.
                    <a href="#"> More info</a></p>
                    <button id="cookies-btn"> Accept cookies</button>
                </div>
            </div>
        </div>
    </div>
    
<!-- javascript cookies -->
<script src="/javascript/script1.js"></script>
<script>
    // method to set a cookie //
    setcookie = (cName, cValue, cExpdays) => {
    let date = new Date();
    date.setTime(date.getTime() + (cExpdays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";

}
// get gookie method //
getCookie = (cName) => {
    const name = cName + "=";
    const cDecoded = decodeURIComponent(document.cookie);
    const cArr = cDecoded.split("; ");
    let value;
    cArr.forEach(val => {
        if (val.indexOf(name) === 0) value = val.substring(name.length);
    })

    return value;
}
/*  Sets cookie if the user presses the accept cookies button*/
document.querySelector("#cookies-btn").addEventListener("click", () => {
    document.querySelector("#cookies").style.display = "none";
    setcookie("cookie", true, 5);
})
/* if cookies are not accepted, the message keeps its display */
cookieMessage = () => {
    if(!getCookie("cookie"))
        document.querySelector("#cookies").style.display = "flex";
}
window.addEventListener("load", cookieMessage);
</script>
</body>
</html>