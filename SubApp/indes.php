<?php

// URL to make the GET request
$url = "https://zuachapaa.tipsmoto.co.ke/Schedule";

// Initialize cURL
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if ($response === FALSE) {
    die('Error occurred while making the request: ' . curl_error($ch));
}

// Close cURL
curl_close($ch);

// Path to the file where the response will be saved
$file_path = './file.txt';

// Save the response to the file
file_put_contents($file_path, $response);
?>
