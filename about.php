<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&display=swap" rel="stylesheet">
    <title>About us</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
</head>

<body>
    <header>
        <?php require_once("navbar.php"); ?>
    </header>
    <main>
        <div class="hero-about">
            <hgroup>
                <h1>About us</h1>
            </hgroup>
        </div>
        <div class="content-about">
            <div class="generaltext">
                <h1>Who are we?</h1>
                        <p>We are a group of students studying artificial intelligence at the University of Amsterdam.
                            We started this project in 2024 for a class we had. We all love travelling and wanted to share 
                            the feeling of exploration and discovering with everyone. This is why we decided to make this page.
                            Our mission is to share the insights we've gained along the way, turning our collective experiences into a valuable resource for fellow explorers.
                            whether you are a seasoned adventurer or you are still waiting to start your first adventure our
                            tips aim to make your trip unforgettable! From navigating through vibrant cities to finding the most relaxing places on earth, 
                            we have all the information to help you find the trip of your dreams.
                            <br><br>Happy travels from our travel team to you!
                        </p>
            </div>
            <div class="image-container">
                <img src="../fotos/mannaastwater.jpg" class="aboutpic" alt="man naast water">
                <img src="../fotos/manopwater.jpg" class="aboutpic" alt="man op water">
                <img src="../fotos/vrouwopstraat.jpg" class="aboutpic" alt="vrouw op straat">
            </div>
            <div class="our-team">
                <h3>Our travel team</h3>
                <div class="members">
                    <div class="member">
                        <div>
                            <img src="../fotos/yaniv.webp" alt="">
                            <h4>Yaniv van der Stigchel</h4>
                        </div>
                        <p>
                            An adventurer through and through; I'm always looking for the next adrenaline rush, <br>
                            whether that's skydiving or scuba diving. But enjoy a quiet evening with a good book <br>
                            I don't turn down a movie either.<br>
                            Fav. country: Guatemala.<br>
                            Fav. activity: Meeting new people.<br>
                            <a href="mailto:yaniv.van.der.stigchel@student.uva.nl">yaniv.van.der.stigchel@student.uva.nl</a></p>
                    </div>
                    <div class="member">
                        <div>
                            <img src="../fotos/thierry.webp" alt="">
                            <h4>Thierry Schneider</h4>
                        </div>
                        <p>I like action and experiencing things, but I wouldn't say no to lying on the beach with a drink either. Discovering new places around the world is most fun with friends.<br>
                            Fav. country: Spain.<br>
                            Fav. activity: Skiing in the Alps.<br>
                            <a href="mailto:thierry.schneider@student.uva.nl">thierry.schneider@student.uva.nl</a></p>
                    </div>
                    <div class="member">
                        <div>
                            <img src="../fotos/jev.webp" alt="">
                            <h4>Jeff Kroon</h4>
                        </div>
                        <p>I love nature and culture. By combining this I often end up on road trips. But I wouldn't say no to a beautiful resort either.<br>
                            Fav. country: New Zealand.<br>
                            Fav. activity: Snowboarding/Surfing.<br>
                            <a href="mailto:jeff.kroon@student.uva.nl">jeff.kroon@student.uva.nl</a></p>
                    </div>
                    <div class="member">
                        <div>
                            <img src="../fotos/aimee.webp" alt="">
                            <h4>Aimée Oijevaar</h4>
                        </div>
                        <p><a href="mailto:aimee.oijevaar@student.uva.nl">aimee.oijevaar@student.uva.nl</a></p>
                    </div>
                    <div class="member">
                        <div>
                            <img src="../fotos/jens.webp" alt="">
                            <h4>Jens Breusers</h4>
                        </div>
                        <p>Ik hou van een leuke uitdaging en ga graag op vakanties. Familiy is voor mij het belangrijkst wat er is, dus ik ga daarom het liefst met hen op reis. <br>
                            Fav. Country: Curaçao.<br>
                            Fav. activity: Surfing.<br><a href="mailto:jens.breusers@student.uva.nl">jens.breusers@student.uva.nl</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="nieuwe_footer_box">
            <div class="box_van_contact_info">
                <table class="footer_tabel">
                    <tr>
                      <th><a href="index.php"><img class="footer_main" src="fotos/logomain.png" alt="Logomain"></a></th>
                      <th id="footer_social"></th>
                    </tr>
                    <tr>
                        <td><a href="https://www.freeprivacypolicy.com/live/3fb7887a-8566-419e-99c6-7db3f28c1e94" target='_blank'">Privacy Policy</a></td>
                        <td><a class="footer_icon" href="https://www.instagram.com/travel_insinder_tips?igsh=dzNvMDVjcjRqMjY3&utm_source=qr"><img src="fotos/instagram_icon.png" alt="insta"></a></td>
                    </tr>
                    <tr>
                        <td><a href="about.php">Contact</a></td>
                        <td><a class="footer_icon" href="https://www.instagram.com/travel_insinder_tips?igsh=dzNvMDVjcjRqMjY3&utm_source=qr"><img src="fotos/facebook_icon.png" alt="facebook"></a></td>
                    </tr>
                    <tr>
                        <td><a href="destinations.php">Destinations</a></td>
                        <td><a class="footer_icon" href="https://www.instagram.com/travel_insinder_tips?igsh=dzNvMDVjcjRqMjY3&utm_source=qr"><img src="fotos/youtube_icon.png" alt="youtube"></a></td>
                    </tr>
                  </table>
            </div>
        </div>
    </footer>
</body>

</html>