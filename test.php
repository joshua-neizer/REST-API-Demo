<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
    

    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
    ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

function GoogleVision($fileName) {
    ini_set('display_errors', 1);

    # [START vision_quickstart]
    # includes the autoloader for libraries installed with composer
    
    putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/pi/code/REST API-fbfd880db2b2.json');
    # instantiates a client
    $imageAnnotator = new ImageAnnotatorClient();


    # prepare the image to be annotated
    $image = file_get_contents($fileName);

    # performs label detection on the image file
    $response = $imageAnnotator->labelDetection($image);
    $labels = $response->getLabelAnnotations();

    $array = [];

    if ($labels) {
        foreach ($labels as $label) {
            array_push($array, rtrim($label->getDescription() . PHP_EOL));
        }
    } else {
        echo('No label found' . PHP_EOL);
    }
    return $array;
}


$results = GoogleVision('uploads/2018-03-19 10.58.59 1_01.jpg');
console_log($results);