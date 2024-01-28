<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>navbar</title>
  <link href='/css/stylesheetnav.css' rel='stylesheet'>
</head>
<body>
  <nav>
    <div class="wrapper"> 
    <div class="logo"><a href="index.php"><img src="/fotos/logomain.png" style="margin-top: 3%;max-width: 50%;" alt="Logo tit"></a></div>
      <input type="radio" name="slider" id="menu-btn">
      <input type="radio" name="slider" id="close-btn">
      <ul class="nav-links">
        <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
        <li><a href="/inspiration.php">Inspiration</a></li>
        <li>
          <a href="destinations.php" class="desktop-item">Destinations</a>
          <input type="checkbox" id="showDrop">
          <label for="showDrop" class="mobile-item">Destinations</label>
          <!-- Dropdown menu for destinations -->
          <ul class="drop-menu"> 
            <li><a href="/centralamerica.php">Central America</a></li>
            <li><a href="europe.php">Europe</a></li>
            <li><a href="#">Oceania</a></li>
            <li><a href="#">Asia</a></li>
          </ul>
        </li>
        <li>
          <a href="#" class="desktop-item">Planner</a>
          <input type="checkbox" id="showMega">
          <label for="showMega" class="mobile-item">Other</label>
          <!-- Mega menu for planning flights, hotels and experiences -->
          <div class="mega-box">
            <div class="content">
              <div class="rownav">
                <img src="/fotos/sunsetsurf.jpg" alt="">
              </div>
              <div class="rownav">
                <header>Flights</header>
                <ul class="mega-links">
                  <li><a href="/flightplanner.php">Flight finder</a></li>
                  <li><a href="/savedflights.php">Saved flights</a></li>
                  <li><a href="/pastflights.php">Past flights</a></li>
                  <li><a href="#">Airline comparisons</a></li>
                </ul>
              </div>
              <div class="rownav">
                <header>Hotels</header>
                <ul class="mega-links">
                  <li><a href="hotelbooker.php">Hotel finder</a></li>
                  <li><a href="savedhotels.php">Saved hotels</a></li>
                  <li><a href="pasthotels.php">Past bookings</a></li>
                  <li><a href="#">Hotel reviews</a></li>
                </ul>
              </div>
              <div class="rownav">
                <header>Experiences</header>
                <ul class="mega-links">
                  <li><a href="experiencebooker.php">Experience finder</a></li>
                  <li><a href="savedexperiences.php">Saved experiences</a></li>
                  <li><a href="#">Past experiences</a></li>
                  <li><a href="#">Experience reviews</a></li>
                </ul>
              </div>
            </div>
          </div> 
        </li>
        <li><a href="/about.php">About</a></li>
        <!-- script for profile, if logged in the "login" button will change to Hello, "user" -->
        <?php if(isset($_SESSION['user_id'])): ?>
          <li style="text-align: end;">
            <a href="javascript:void(0)" class="desktop-item">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
            <input type="checkbox" id="showDrop">
            <label for="showDrop" class="mobile-item">Profile</label>
            <ul class="drop-menu">
              <a href="profile.php">Profile</a>
              <a href="logout.php">Logout</a>
        </ul>
          </li>
        <?php else: ?>
          <li><a class="login" href="login.php" id="loginnav">Login</a></li>
        <?php endif; ?>
      </ul>
      <label for="menu-btn" class="btn menu-btn" style="background-color: #986e46;"><i class="fas fa-bars"></i></label>
    </div> 
  </nav>
</body>
</html>
