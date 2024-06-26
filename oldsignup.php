<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
    <link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>
<?php require_once("navbar.php"); ?>
</div>
    <div class="form-container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <form action="signupscript.php" method="post" class="formsignup">
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