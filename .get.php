<?php 
    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
    ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    $context = stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => "Authorization: {$authToken}\r\n"
        )
    ));

    // Send the request
    $response = file_get_contents('http://192.168.2.44:5000/photos', FALSE, $context);

    // Check for errors
    if($response === FALSE){
        console_log('ERROR: could not get');
    }

    echo $response;
?>