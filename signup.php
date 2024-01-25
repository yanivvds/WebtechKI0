<?php
$errorMessage = '';
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["username"])) {
        $errorMessage = "Name is required";
        $is_invalid = true;
    }

    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Valid email is required";
        $is_invalid = true;
    }

    if (strlen($_POST["password"]) < 8) {
        $errorMessage = "Password must be at least 8 characters";
        $is_invalid = true;
    }

    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        $errorMessage = "Password must contain at least one letter";
            $is_invalid = true;
    }

    if ( ! preg_match("/[0-9]/", $_POST["password"])) {
        $errorMessage = "Password must contain at least one number";
            $is_invalid = true;
    }

    if ($_POST["password"] !== $_POST["password_confirmation"]) {
        $errorMessage = "Passwords have to be the same";
        $is_invalid = true;
    }
    if (!$is_invalid) {
        // Ga alleen door als er geen errors zijn.
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $mysqli = require __DIR__ . "/../database.php";
        $sql = "INSERT INTO Users (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            $errorMessage = "SQL ERROR: " . $mysqli->error;
            $is_invalid = true;
        } else {
            $stmt->bind_param("sss", $_POST["username"], $_POST["email"], $password_hash);

            if ($stmt->execute()) {
                header("Location: signupsucces.html");
                exit;
            } else {
                if ($stmt->errno === 1062) {
                    $errorMessage = "Email has already been used.";
                    $is_invalid = true;
                } else {
                    die($mysqli->error . " " . $mysqli->errno);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>
<?php require_once("navbar.php"); ?>
    <div class="form-container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <?php if ($is_invalid): ?>
        <div class="error-message"><?= nl2br(htmlspecialchars($errorMessage)) ?></div>
    <?php endif; ?>
        <form method="post" class="formsignup">
            <div class="title">Sign-up</div>
    
            <div class="input-container ic1">
                <input type="text" id="username" name="username" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="username" class="placeholder">Username</label>
            </div>
    
            <div class="input-container ic2">
                <input type="email" id="email" name="email" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="email" class="placeholder">Email</label>
            </div>
    
            <div class="input-container ic1">
                <input type="password" id="password" name="password" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="password" class="placeholder">Password</label>
            </div>
    
            <div class="input-container ic2">
                <input type="password" id="password_confirmation" name="password_confirmation" class="input" placeholder=" " required />
                <div class="cut"></div>
                <label for="password_confirmation" class="placeholder">Repeat password</label>
            </div>
    
            <button type="submit" class="submit">Sign-up</button>
        </form>
    </div>
</body>
</html>