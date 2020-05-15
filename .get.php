<?php 
    // Sends get request to the server
    $context = stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => "Authorization: {$authToken}\r\n"
        )
    ));

    // Send the request
    $response = file_get_contents('http://localhost:5000/photos', FALSE, $context);

    // Check for errors
    if($response === FALSE){
        console_log('ERROR: could not get');
    }

    echo $response;
?>