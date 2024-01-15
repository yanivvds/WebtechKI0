<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

$id = $_SESSION["user_id"];

$stmt = $mysqli->prepare("SELECT username, email, firstName, lastName, city, phoneNumber, birthday FROM Users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($username, $email, $firstName, $lastName, $city, $phoneNumber, $birthday);
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
<div>
<?php include 'navbar.php'; ?>
</div>
    <div class="form-container" style="display: flex; justify-content: center; align-items: center; height: auto;">
        <div class="profile">
        <div class="container">
            <h1 style="font-size: 36px; color: #7d4471;">User Profile</h1>
            <form action="updateprofile.php" method="POST">

        <div class="input-container ic1">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" disabled><br>
        </div>

        <div class="input-container ic2">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" disabled><br>
        </div>

        <div class="input-container ic1">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>"><br>
        </div>

        <div class="input-container ic2">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>"><br>
        </div>
        
        <div class="input-container ic1">
            <label for="city">Home Location:</label>
            <input type="text" id="city" name="city" value="<?php echo $city; ?>"><br>
        </div>

        <div class="input-container ic2">
            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>"><br>
        </div>

        <div class="input-container ic1">
            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday" value="<?php echo $birthday; ?>"><br>
        </div>

            <input type="submit" value="Update Profile">
    </form> 
            </div>
        </div>
    </div>
</body>
</html>