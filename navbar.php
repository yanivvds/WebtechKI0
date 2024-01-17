<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<html>
    <head>
        <title>navbar</title>
        <link rel="stylesheet" href="css/stylesheet.css">
    </head>
    <body>
        <div id="myNav" class="overlay">
            <div class="overlay-content">
                <a href="inspiration.php">Inspiration</a>
                <a href="destinations.php">Destinations</a>
                <a href="#">Flights</a>
                <a href="#">Contact</a>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            </div>
        </div>
        <header class="header">
            <div class="logo">
                <a href="index.php"><img src="fotos/logomain.png" alt="Logomain"></a>
            </div>
            <nav>
                <ul class="navbar">
                    <li class="link"><a href="destinations.php" id="destinationsnav">Destinations</a></li>
                    <li class="link"><a href="inspiration.php" id="topspotsnav">Inspiration</a></li>
                    <span id="menubtn" style="font-size:40px;cursor:pointer; color: #fff; margin-bottom: 5px" onclick="openNav()">&#9776;</span>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropbtn">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                            <div class="dropdown-content">
                                <a href="profile.php">Profile</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a class="login" href="login.php" id="loginnav">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>
    </body>
</html>
