<?php
/* Uses strict mode to conduct safe cookies */
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'ki0.webtech-uva.nl', 
    'path' => '/',
]);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/* Checks if the session id needs to be regenerated if the time interval is reached. */
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id();
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 10000;
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id();
        $_SESSION['last_regeneration'] = time();
    }
}
