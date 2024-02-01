<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['pin'])) {
            $pin = $_POST['pin'];
            // Write the pin data to locatie.txt
            file_put_contents('locatie.txt', $pin);
            // Run the Python script
            $command = escapeshellcmd("python scraper.py $pin");
            shell_exec($command);
        }
    }
?>
