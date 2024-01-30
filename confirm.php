<?php
$mysqli = require __DIR__ . "/../database.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT * FROM Users WHERE token = ?";
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        echo "SQL Error";
    } else {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $update_sql = "UPDATE Users SET token = '', status = 'confirmed' WHERE token = ?";
            if (!$stmt->prepare($update_sql)) {
                echo "SQL Error";
            } else {
                $stmt->bind_param("s", $token);
                $stmt->execute();
                echo "Email confirmed successfully!";
            }
        } else {
            echo "Invalid token!";
        }
    }
} else {
    echo "No token provided!";
}
?>