<!DOCTYPE html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    require_once 'config.php';
    session_start();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/stylesheet.css" rel="stylesheet">
    <title>Footer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
</head>
<body>
    <!--Waves Container-->
<div>
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255, 0.7)" />
    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255, 0.5)" />
    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255, 0.3)" />
    <use xlink:href="#gentle-wave" x="48" y="7" fill="rgba(255,255,255, 0.849)" />
    </g>
    </svg>
    </div>
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
</body>

</html>