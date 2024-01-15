<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM Users
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with the provided email.";
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>
<div id="myNav" class="overlay">
            <div class="overlay-content">
              <a href="top_spots.html">Top Spots</a>
              <a href="destinations.html">Destinations</a>
              <a href="#">Flights</a>
              <a href="#">Contact</a>
              <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
              
            </div>
        </div>
            <header class="header">
                <div class="logo">
                    <a href="index.html"><img src="fotos/logomain.png" alt="Logomain"></a>
                </div>
                <nav>   
                    <ul class="navbar">
                        <li class="link"><a href="destinations.html" id="destinationsnav">Destinations</a></li>
                        <li class="link"><a href="top_spots.html" id="topspotsnav">Top Spots</a></li>
                        <li><a class="login" href="login.html" id="loginnav">Login</a></li>
                    </ul>
                    <span id="menubtn" style="font-size:40px;cursor:pointer; color: #fff;" onclick="openNav()">&#9776;</span>
                </nav>
            </header>
</div>

    <div class="form-container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <form method="post" class="formlogin">
            <div class="title">Login</div>

            <div class="input-container ic1">
                <input type="email" name="email" id="email" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="email" class="placeholder">Email</label>
            </div>

            <div class="input-container ic2">
                <input type="password" name="password" id="password" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="password" class="placeholder">Password</label>
            </div>

            <button type="submit" class="submit">Login</button>
            <p style="margin-top: 20px;">Don't have an account? <a href="signup.html">Sign up</a></p>
        </form>
    
    </div>
</body>
</html>