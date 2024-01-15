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
    <form action="updateprofile.php" method="POST" class="formlogin" style="height; auto">
        <div class="title" style="font-size: 36px; color: #7d4471;">User Profile</div>
    
        <div class="input-container ic1">
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" class="input" placeholder=" " disabled />
            <div class="cut"></div>
            <label for="username" class="placeholder">Username</label>
        </div>

        <div class="input-container ic2">
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="input" placeholder=" " disabled />
            <div class="cut"></div>
            <label for="email" class="placeholder">Email</label>
        </div>


        <div class="input-container ic1">
            <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" class="input" placeholder=" " />
            <div class="cut"></div>
            <label for="firstName" class="placeholder">First Name</label>
        </div>

        <div class="input-container ic2">
            <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" class="input" placeholder=" " />
            <div class="cut"></div>
            <label for="lastName" class="placeholder">Last Name</label>
        </div>
        
        <div class="input-container ic1">
            <input type="text" id="city" name="city" value="<?php echo $city; ?>" class="input" placeholder=" " />
            <div class="cut"></div>
            <label for="city" class="placeholder">Home Location</label>
        </div> 

        <div class="input-container ic2">
            <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>" class="input" placeholder=" " />
            <div class="cut"></div>
            <label for="phoneNumber" class="placeholder">Phone Number</label>
        </div>

        <div class="input-container ic1">
            <input type="date" id="birthday" name="birthday" value="<?php echo $birthday; ?>" class="input" placeholder=" " />
            <div class="cut"></div>
            <label for="birthday" class="placeholder">Birthday</label>
        </div>

        <button type="submit" class="submit">Update Profile</button>
    </form> 
</div>
</body>
</html>