<?php 
    unlink(dirname(__FILE__) . '/uploads/' . $_GET['file']);

    $command = escapeshellcmd('python3 /home/pi/code/MY_API/generateID.py "' . $_GET['file'] .'"');
    $output = shell_exec($command);
    echo $output;

    $context = stream_context_create(array(
        'http' => array(
            // http://www.php.net/manual/en/context.http.php
            'method' => 'DELETE',
            'header' => "Authorization: {$authToken}\r\n"
        )
    ));

    // Send the request
    $response = file_get_contents('http://localhost:5000/photos/' . rtrim($output), FALSE, $context);

    // Check for errors
    if($response === FALSE){
        console_log('ERROR: the file did not delete');
    }

    // Decode the response
    $responseData = json_decode($response, TRUE);

    // Print the date from the response
    echo $responseData['published'];
?>