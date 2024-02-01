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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inspiration</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
    <link href="css/stylesheetsubpages.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- navbar insertion -->
    <?php require_once("navbar.php"); ?>
    <div class="container">
        <!-- title bar in the document -->
        <div class="containertekst" style="margin-bottom: 2%; margin-top: -6.5%;">
            <h1>Travel Blog</h1>
            <p>Find inspiration for your next trip in this blog</p>
        </div>
        <!-- gallery with al articles -->
        <div class="gallery">
            <div class="gallery__item gallery__item--1">
                <a href="#">
                    <div class="imagediv--1">
                        <h5>Amalfi Coast</h5>
                        <p class="hide1">Cliffside villages, azure sea, and culinary delights.</p>
                    </div>
                    </a>
            </div>
            <div class="gallery__item gallery__item--2">
                <a href="#">
                    <div class="imagediv--2">
                        <h5>European underdogs</h5>
                        <p>Discover budget-friendly charm in Eastern European delights</p>
                    </div>
                    </a>
            </div>
            <div class="gallery__item gallery__item--3">
                <a href="#">
                    <div class="imagediv--3">
                        <h5>Tokyo Beyond the Bright Lights</h5>
                        <p>Beneath Tokyo's dazzling skyline lies a world of hidden wonders. Embark on a journey beyond the neon glow, where historic temples whisper tales and culinary delights paint a vibrant portrait. Curiosity beckons, click to unveil Tokyo's best-kept secrets!</p>
                    </div>
                </a>
            </div>
            <div class="gallery__item gallery__item--4">
                <a href="#">
                    <div class="imagediv--4">
                        <h5>Surfing Odyssey: Where Waves Meet Wonder</h5>
                        <p>Explore the World's Best Surf Spots! From Bali's barrels to California's breaks, discover the allure of each coastal gem. Immerse in local vibes, savor seaside delights, and ride the waves of pure serenity. Ready for a surf adventure? Click to chase waves and coastal charm!"</p>
                    </div>
                </a>
            </div>
            <div class="gallery__item gallery__item--5">
                <a href="#">
                    <div class="imagediv--5">
                        <h5>Savoring Italy's Culinary Delights</h5>
                        <p>Savor Italy's Culinary Symphony: Pasta, Pizza, Truffles, Gelato, and Regional Wines. A Gastronomic Journey</p>
                    </div>
                </a>
            </div>
            <div class="gallery__item gallery__item--6">
                <a href="#">
                    <div class="imagediv--6">
                        <h5>Mystical Mexico</h5>
                        <p>Experience the Kaleidoscope of Mexico: Savory Culinary Feasts, Sun-Kissed Beaches, Ancient Temples, and Rich History Unfold in Every Corner</p>
                    </div>
                    </a>
            </div>
        </div>
        <!-- Title bar with title of carousel -->
        <div class="title2" style="margin-top: 2%; margin-bottom: 2%;">
            <h2>Oregon</h2>
            <p>Wide beaches and wild nature</p>
        </div>
        <!-- carousel with pictures of Oregon -->
        <div class="containercarousel">
            <div class="carousel">
                <input type="radio" name="slides" checked="checked" id="slide-1">
                <input type="radio" name="slides" id="slide-2">
                <input type="radio" name="slides" id="slide-3">
                <input type="radio" name="slides" id="slide-4">
                <input type="radio" name="slides" id="slide-5">
                <input type="radio" name="slides" id="slide-6">
                <ul class="carousel__slides">
                    <li class="carousel__slide">
                        <figure>
                            <div>
                                <a href="#"><img src="https://picsum.photos/id/1041/800/450" alt=""></a>
                            </div>
                            <figcaption>
                                <span class="credit">Photo: Tim Marshall</span>
                            </figcaption>
                        </figure>
                    </li>
                    <li class="carousel__slide">
                        <figure>
                            <div>
                                <a href="#"><img src="https://picsum.photos/id/1043/800/450" alt=""></a>
                            </div>
                            <figcaption>
                                <span class="credit">Photo: Christian Joudrey</span>                            
                            </figcaption>
                        </figure>
                    </li>
                    <li class="carousel__slide">
                        <figure>
                            <div>
                                <a href=""><img src="https://picsum.photos/id/1044/800/450" alt=""></a>
                            </div>
                            <figcaption>
                                
                                <span class="credit">Photo: Steve Carter</span>                            
                            </figcaption>
                        </figure>
                    </li>
                    <li class="carousel__slide">
                        <figure>
                            <div>
                               <a href=""><img src="https://picsum.photos/id/1045/800/450" alt=""></a>
                            </div>
                            <figcaption>
                                
                                <span class="credit">Photo: Aleksandra Boguslawska</span>                            
                            </figcaption>
                        </figure>
                    </li>
                    <li class="carousel__slide">
                        <figure>
                            <div>
                                <a href=""><img src="https://picsum.photos/id/1049/800/450" alt=""></a>
                            </div>
                            <figcaption>
                               
                                <span class="credit">Photo: Rosan Harmens</span>                            
                            </figcaption>
                        </figure>
                    </li>
                    <li class="carousel__slide">
                        <figure>
                            <div>
                                <a href=""><img src="https://picsum.photos/id/1052/800/450" alt=""></a>
                            </div>
                            <figcaption>
                                
                                <span class="credit">Photo: Annie Spratt</span>                            
                            </figcaption>
                        </figure>
                    </li>
                </ul>    
                <ul class="carousel__thumbnails">
                    <li>
                        <label for="slide-1"><img src="https://picsum.photos/id/1041/150/150" alt=""></label>
                    </li>
                    <li>
                        <label for="slide-2"><img src="https://picsum.photos/id/1043/150/150" alt=""></label>
                    </li>
                    <li>
                        <label for="slide-3"><img src="https://picsum.photos/id/1044/150/150" alt=""></label>
                    </li>
                    <li>
                        <label for="slide-4"><img src="https://picsum.photos/id/1045/150/150" alt=""></label>
                    </li>
                    <li>
                        <label for="slide-5"><img src="https://picsum.photos/id/1049/150/150" alt=""></label>
                    </li>
                    <li>
                        <label for="slide-6"><img src="https://picsum.photos/id/1052/150/150" alt=""></label>
                    </li>
                </ul>
            </div>
        </div>
    </section>
        <!--end carousel -->
    </div>
    <div style="z-index: 10;min-height: 0%;margin-top: 42%;position: absolute;bottom: 0;left: 0;width: 100%;position: relative;flex: 1;">
        <!-- insert footer -->
        <?php require_once("footer.php"); ?>
    </div>
    <script src="/javascript/script1.js"></script>
</body>
</html>

    