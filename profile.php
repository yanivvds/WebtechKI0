<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

$id = $_SESSION["user_id"];

$stmt = $mysqli->prepare("SELECT first_name, last_name, city, phone_number, birthday FROM Users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $city, $phoneNumber, $birthday);
$stmt->fetch();
$stmt->close();

$mysqli->close();
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