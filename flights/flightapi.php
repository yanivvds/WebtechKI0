<?php
include('config.php');

$client_id = $config['client_id'];
$client_secret = $config['client_secret'];

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v1/security/oauth2/token');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials&client_id=' . $client_id . '&client_secret=' . $client_secret);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session and get the response
$response = curl_exec($ch);
$response = json_decode($response, true); 

// Close cURL session
curl_close($ch);

// Extract the access token
$access_token = $response['access_token'] ?? '';
