<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="index.css" rel="stylesheet">
        <link rel="icon" href="icon.png" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">
        <!--You can go to Google Fonts and insert your own font here-->
        <title>&#8226; API &#8226;</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://rawgit.com/thielicious/selectFile.js/master/selectFile.js"></script>
    </head>
    <body>
        <div class="space"></div>
        <h1>API DEMO</h1>
        <p class="results">
            <?php
                function console_log($output, $with_script_tags = true) {
                    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
                ');';
                    if ($with_script_tags) {
                        $js_code = '<script>' . $js_code . '</script>';
                    }
                    echo $js_code;
                }

                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $descriptor = $_POST['desc'];
                $descriptor = ($descriptor == "") ? "miscellaneous" : strtolower(explode(" ", $descriptor) [0]);

                console_log($descriptor);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if ($check !== false) {
                        console_log("COMPLETE: File is an image - " . $check["mime"] . ".");
                        $uploadOk = 1;
                    } else {
                        console_log("ERROR: File is not an image.");
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if(file_exists($target_file)) {
                    console_log("ERROR: Sorry, file already exits.");
                    $uploadOk = 0;
                }

                // Check file size
                if($_FILES["fileToUpload"]["size"] > 5000000){
                    console_log("ERROR: Sorry, your file is too large.");
                    console_log($_FILES["fileToUpload"]["size"]);
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif"){
                    console_log("ERROR: Sorry, only JPG, JPEG, PNG, GIF files are allowed.");
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if($uploadOk == 0){
                    console_log("ERROR: Sorry, our file was not uploaded.");
                    echo "<b>ERROR</b> the file did not upload";
                } else {
                    // If everything is okay, try to upload the file
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "<b>Complete</b> The file uploaded";
                        console_log("COMPLETE: The file " . basename($_FILES["fileToUpload"]["name"]). " has been uploaded.");
                        // The data to send to the API
                        $postData = array(
                            'file_name' => basename($_FILES["fileToUpload"]["name"]),
                            'size' => $_FILES["fileToUpload"]["size"].'KB',
                            'descriptor' => $descriptor
                        );

                        console_log(json_encode($postData));
                        

                        // Create the context for the request
                        $context = stream_context_create(array(
                            'http' => array(
                                // http://www.php.net/manual/en/context.http.php
                                'method' => 'POST',
                                'header' => "Authorization: {$authToken}\r\n".
                                    "Content-Type: application/json\r\n",
                                'content' => json_encode($postData)
                            )
                        ));

                        // Send the request
                        $response = file_get_contents('http://localhost:5000/photos', FALSE, $context);

                        // Check for errors
                        if($response === FALSE){
                            console_log('ERROR: the file did not post');
                        }

                        // Decode the response
                        $responseData = json_decode($response, TRUE);

                        // Print the date from the response
                        echo $responseData['published'];
                    } else {
                        console_log("ERROR: Sorry, there was an error uploading your file");
                    }
                }
            ?>
        </p>
        <div style="padding: 20px;"></div>
        <a href="index.html"><button class="home">Go Back Home</button></a>
        <div style="padding: 30px;"></div>
        <a href="repository.php"><button class="repository">Repository</button></a>
    </body>
</html>