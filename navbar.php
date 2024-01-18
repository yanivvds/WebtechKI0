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
      <div class="logo"><img href="index.php" src="/fotos/logomain.png" alt="Logomain" style="margin-top: 20px;"></div>
      <input type="radio" name="slider" id="menu-btn">
      <input type="radio" name="slider" id="close-btn">
      <ul class="nav-links">
        <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
        <li><a href="inspiration.php">Inspiration</a></li>
        <li>
          <a href="destinations.php" class="desktop-item">Destinations</a>
          <input type="checkbox" id="showDrop">
          <label for="showDrop" class="mobile-item">Dropdown Menu</label>
          <ul class="drop-menu">
            <li><a href="#">Central America</a></li>
            <li><a href="#">Europe</a></li>
            <li><a href="#">Oceania</a></li>
            <li><a href="#">Asia</a></li>
          </ul>
        </li>
        <li>
          <a href="#" class="desktop-item">Planner</a>
          <input type="checkbox" id="showMega">
          <label for="showMega" class="mobile-item">Other</label>
          <div class="mega-box">
            <div class="content">
              <div class="row">
                <img src="/fotos/sunsetsurf.jpg" alt="">
              </div>
              <div class="row">
                <header>Flights</header>
                <ul class="mega-links">
                  <li><a href="#">Flight finder</a></li>
                  <li><a href="#">Saved flights</a></li>
                  <li><a href="#">Past flights</a></li>
                  <li><a href="#">Airline comparisons</a></li>
                </ul>
              </div>
              <div class="row">
                <header>Hotels</header>
                <ul class="mega-links">
                  <li><a href="#">Hotel finder</a></li>
                  <li><a href="#">Saved hotels</a></li>
                  <li><a href="#">Past bookings</a></li>
                  <li><a href="#">Hotel reviews</a></li>
                </ul>
              </div>
              <div class="row">
                <header>Expiriences</header>
                <ul class="mega-links">
                  <li><a href="#">Experience finder</a></li>
                  <li><a href="#">Saved experiences</a></li>
                  <li><a href="#">Past experiences</a></li>
                  <li><a href="#">Experience reviews</a></li>
                </ul>
              </div>
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
                    <li> <span id="menubtn" style="font-size:40px;cursor:pointer; color: #fff;" onclick="openNav()">&#9776;</span></li>
            </div>
          </div>
        </li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
      <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
    </div>
  </nav>
</body>
</html>