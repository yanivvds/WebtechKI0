<?php
// This file is used to perform the login function by using the database.
// And setting it to the session.
require_once 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL); ini_set('display_errors', 1);
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/../database.php";
    
    $sql = sprintf("SELECT * FROM Users
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            $_SESSION["user_id"] = $user["id"];

            $_SESSION["username"] = $user["username"];

            $_SESSION['email'] = $user['email'];
            
            
            $consent = $_COOKIE['cookie'] ?? false;
            if ($consent){
                setcookie('username', $user["username"], time() + 86400 * 2);
                setcookie('id', $user["id"], time() + 86400 * 2);
                setcookie('loggedin','yes', time() + 86400 * 2);
                header("Location: index.php");
                exit;
            }
            header("Location: index.php");
            exit;
            }
        }

    $is_invalid = true;
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
<?php include 'navbar.php'; ?>
    <div class="form-container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <form method="post" class="formlogin">
        <?php if ($is_invalid): ?>
            <em style="color: #840000;">Invalid login</em>
        <?php endif; ?>
            <div class="title">Login</div>

            <div class="input-container ic1">
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="email" class="placeholder">Email</label>
            </div>

            <div class="input-container ic2">
                <input type="password" name="password" id="password" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="password" class="placeholder">Password</label>
            </div>

            <button type="submit" class="submit">Login</button>
            <p style="margin-top: 20px;">Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
    
    </div>
</body>
</html>