<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="index.css" rel="stylesheet">
        <link href="select.css" rel="stylesheet">
        <link href="slider.css" rel="stylesheet">
        <link rel="icon" href="icon.png" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
        <title>&#8226; API &#8226;</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
        <script type="text/javascript" src="https://rawgit.com/thielicious/selectFile.js/master/selectFile.js"></script>
          
    </head>
    <body id="top">
        <div class="space"></div>
        <h1>API DEMO</h1>
        <h2 class="subheader">Repository</h2>
        <a href="index.html"><button class="home">Go Back Home</button></a>
        <div style="padding: 20px;"></div>
        <div id="display">
            <label class="box" id="initial">
                <input class="display" type="radio" value="0" name="radio"  checked="checked">
                <span class="checkmark"></span>
            </label>
            <label class="box" id="square">
                <input class="display" type="radio" value="1" name="radio">
                <span class="checkmark"></span>
            </label>
            <label class="box" id="card">
            <input class="display" type="radio" value="2" name="radio">
                <span class="checkmark"></span>
            </label>
        </div>
        <form id="app-cover">
            <div id="select-box">
                <input type="checkbox" id="options-view-button">
                <div id="select-button" class="brd">
                    <div id="selected-value">Sort...</div>
                    <div id="chevrons">
                        <i class="fas fa-chevron-up"></i>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div id="options">
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="file_name false 0">
                        <input class="s-c bottom" type="radio" name="platform" value="file_name false 0">
                        <!-- <i class="fab fa-codepen"></i> -->
                        <span class="label">A to Z</span>
                        <span class="opt-val">A to Z</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="file_name true 1">
                        <input class="s-c bottom" type="radio" name="platform" value="file_name true 1">
                        <!-- <i class="fab fa-dribbble"></i> -->
                        <span class="label">Z to A</span>
                        <span class="opt-val">Z to A</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="size false 2">
                        <input class="s-c bottom" type="radio" name="platform" value="size false 2">
                        <!-- <i class="fab fa-behance"></i> -->
                        <span class="label">Size</span>
                        <span class="opt-val">Size</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="size true 3">
                        <input class="s-c bottom" type="radio" name="platform" value="size true 3">
                        <!-- <i class="fab fa-behance"></i> -->
                        <span class="label">Rev-Size</span>
                        <span class="opt-val">Rev-Size</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="date_modified false 4">
                        <input class="s-c bottom" type="radio" name="platform" value="date_modified false 4">
                        <!-- <i class="fab fa-hackerrank"></i> -->
                        <span class="label">Old to New</span>
                        <span class="opt-val">Old to New</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="date_modified true 5">
                        <input class="s-c bottom" type="radio" name="platform" value="date_modified true 5">
                        <!-- <i class="fab fa-stack-overflow"></i> -->
                        <span class="label">New to Old</span>
                        <span class="opt-val">New to Old</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="descriptor false 6">
                        <input class="s-c bottom" type="radio" name="platform" value="descriptor false 6">
                        <!--  <i class="fab fa-free-code-camp"></i> -->
                        <span class="label">Description</span>
                        <span class="opt-val">Description</span>
                    </div>
                    <div id="option-bg"></div>
                </div>
            </div>
        </form>
        <div class="slidecontainer">
            <input type="range" min="50" max="300" value="300" class="range" id="myRange">
        </div>
        <div class="space+"></div>
        <div class="counter mobile-off">
            <label id="select-A" class="selec">0</label>
            <p class="sel">Selected</p>
            <button id="delete" class="delete action">delete</button>
            <button id="download" class="download action">download</button>
            <button id="clear" class="clear">clear</button>
        </div>
        <div class="counter mobile-on">
            <label id="select-B" class="selec">0</label>
            <p class="sel">Selected</p>
            <button id="delete" class="delete action">del</button>
            <button id="download" class="download action">down</button>
            <button id="clear" class="clear">clr</button>
        </div>
        <div class="gallery">
            <?php
                $files = glob("uploads/*.*");
                for ($i=0; $i<count($files); $i++)
                {
                    $image = $files[$i];
                    $supported_file = array(
                            'gif',
                            'jpg',
                            'jpeg',
                            'png'
                    );

                    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                    if (in_array($ext, $supported_file)) {
                        // echo basename($image)."<br />"; // show only image name if you want to show full path then use this code // echo $image."<br />";
                        echo '<div class="card">
                                <img id="p' . $i .'" src="'.$image .'" alt="Random image" />
                            </div>';
                    } else {
                        continue;
                    }
                }
            ?>
        </div>
        <div style="padding: 40px;"></div>
        <a href="#top"><button class="home">Top</button></a>
        <div class="space"></div>
        <script src="repository.js"></script>
        <script src="slider.js"></script>
        <script src="scroll.js"></script>
    </body>
</html>