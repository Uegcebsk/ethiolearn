<?php
// Get the URL to fetch from the query parameters
$url = $_GET['url'];

// Create a stream context to make the request
$context = stream_context_create([
    'http' => [
        'method' => 'GET', // Or 'POST' if required
    ],
]);

// Fetch the data from the URL
$response = file_get_contents($url, false, $context);

// Forward the response headers to the client
foreach ($http_response_header as $header) {
    header($header);
}

// Output the response
echo $response;
?>
