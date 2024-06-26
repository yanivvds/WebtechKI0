<?php
require_once 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Insider</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
    <link href="css/stylemainpage.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="fotodiv1">
        <h1>Explore The world</h2>
        <p>Discover a world of travel possibilities, where every page unfolds new <br>adventures and valuable insights</p>
    </div>
    <div class="golfpagina1">
        <h3 style="margin-top:-27rem;">Explore</h3>
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
            <p>Explore Asia's allure: ancient wonders, modern marvels, and a tapestry of cultures. From Japan's serene temples to Bali's tropical paradise.</p>
        </div>
    </div>
    </div>
    <div class="test">
        <h3>Enchanting Cappadocia</h3>
        <p>Where Magic Awakens Beneath the Rocks</p>
        <button class="exploreknop">Explore</button>
    </div>
    <div class="golfpagina2">
        <div class="gallery">
            <h3 style="margin-top: -5rem">Gather your companions and hit the road</h3>
            <div class="gallery__item gallery__item--1">
                <a href="#">
                    <div class="imagediv--1">
                        <h5>The Amalfi Coast</h5>
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
<script src="/javascript/script1.js"></script>
</body>
</html>