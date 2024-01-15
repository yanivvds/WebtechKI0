<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Session info
$username = htmlspecialchars($_SESSION["username"]);
$email = htmlspecialchars($_SESSION["email"]);
$last_name = $_POST["first_name"] ?? 'John'; 
$last_name = $_POST["last_name"] ?? 'Doe'; 
$home_location = $_POST["home_location"] ?? 'New York';
$phone_number = $_POST["phone_number"] ?? '123456789';
$birthday = $_POST["birthday"] ?? '01-01-2000';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="stylesheet.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="profile">
        
        <div class="container">
            <h1>User Profile</h1>
            <form action="update_profile.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" disabled><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" disabled><br>

            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>"><br>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>"><br>

            <label for="homeLocation">Home Location:</label>
            <input type="text" id="homeLocation" name="homeLocation" value="<?php echo $homeLocation; ?>"><br>

            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>"><br>

            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday" value="<?php echo $birthday; ?>"><br>

            <input type="submit" value="Update Profile">
    </form>
        </div>
    </div>
</body>
</html>