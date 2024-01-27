<?php
include('/var/www/config.php');

$apiEndpoint = "https://test.api.amadeus.com/v1/security/oauth2/token";

$clientID = $config['client_id'];
$clientSecret = $config['client_secret'];

// cURL-sessie initialiseren
$ch = curl_init($apiEndpoint);

// cURL-opties instellen
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id={$clientID}&client_secret={$clientSecret}");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded',
));

// cURL-verzoek uitvoeren
$response = curl_exec($ch);
$response = json_decode($response, 1); 

// Controleren op fouten
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
}

// cURL-sessie sluiten
curl_close($ch);

// Verwerken van het resultaat
$access_token = $response['access_token'] ?? '';
?>
