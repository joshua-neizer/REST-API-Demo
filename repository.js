// Select all links with hashes
$('a[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function (event) {
        // On-page links
        if (
            location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
            &&
            location.hostname == this.hostname
        ) {
            // Figure out element to scroll to
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            // Does a scroll target exist?
            if (target.length) {
                // Only prevent default if animation is actually gonna happen
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000, function () {
                    // Callback after animation
                    // Must change focus!
                    var $target = $(target);

                });
            }
        }
    });



// Functions
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function order(objs, attr, reverse=false) {
    console.log(objs);
    if (reverse){
        return objs.sort((a, b) => (a [attr] > b [attr]) ? -1 : ((b [attr] > a [attr]) ? 1 : 0)); 
    }

    return objs.sort((a,b) => (a [attr] > b [attr]) ? 1 : ((b [attr] > a [attr]) ? -1 : 0)); 
}

function sortPhotos(attr, reverse){
    reverse = reverse == "true";
    data = order(data, attr, reverse)

    for (var x in data) {
        $('#p' + x).attr('src', "uploads/" + data [x] ['file_name'])
    }
}

function changeDisplay(D){
    $("img").css('height', display [D]);
    $("img").css('object-fit', 'cover');
    state = D;
    scale();

    if (D == 0){
        $(".slidecontainer").css('opacity', '0');
    } else {
        $(".slidecontainer").css('opacity', '1');
    }

    switch(D) {
        case 0:
            $("#initial").attr('class', 'box on');
            $("#square").attr('class', 'box off');
            $("#card").attr('class', 'box off');
            break;
        case 1:
            $("#initial").attr('class', 'box off');
            $("#square").attr('class', 'box on');
            $("#card").attr('class', 'box off');
            break;
        case 2:
            $("#initial").attr('class', 'box off');
            $("#square").attr('class', 'box off');
            $("#card").attr('class', 'box on');
            break;
    }

    setCookie('display', String(D), 7);
}

function scale(){
    switch (state){
        case 1:
            $("img").css('height', display [1]);
            $("img").css('width', display [1]);
            $("div.card").css('width', (+display[3] + +15) + 'px');
            $("div.card").css('height', (+display[3] + +15) + 'px');
            $("div.gallery").css('grid-template-columns', 'repeat(auto-fit, minmax(' + display [1] +', 1fr))');

            $("img").hover(function(){
                    $(this).css("width", (+display [3] + +10) + 'px');
            }, function(){
                    $(this).css("width", display[1]);
            });

            break;
        case 2:
            $("img").css('height', display [2]);
            $("img").css('width', display [1]);
            $("div.card").css('width', (+display[3] + +15) + 'px');
            $("div.card").css('height', display[2]);
            $("div.gallery").css('grid-template-columns', 'repeat(auto-fit, minmax(' + display [1] +', 1fr))');
            $("img").hover(function(){
                    $(this).css("width", (+display [3] + +10) + 'px');
            }, function(){
                    $(this).css("width", display[1]);
            });
            break;
        default:
            $("img").css('height', 'initial');
            $("img").css('width', '300px');
            $("div.card").css('width', 'initial');
            $("div.card").css('height', '475px');
            $("div.gallery").css('grid-template-columns', 'repeat(auto-fit, minmax(300px, 1fr))');
            $("img").hover(function(){
                $(this).css("width", '310px');
            }, function(){
                    $(this).css("width", '300px');
            });
            break;
    }
}

function __init__(callback) {  
    $.get(".get.php").done(function (JSON_DATA) {
        callback(JSON.parse(JSON_DATA)['data']);
    }); 
}


// On Button Press

$('img').click(function () {
    if ($(this).css('border') == '0px solid rgb(30, 144, 255)') {
        $(this).css('border', '4px solid dodgerblue');
        $(this).css('width', (+display [3] + +10) + 'px');
        select[$(this).attr('id')] = $(this).attr('src');
        // if (state == 1){$(this).css('height', '310px');}
        counter++;
    } else {
        $(this).css('border', '0px solid dodgerblue');
        $(this).css('width', display[1]);
        // if (state == 1){$(this).css('height', '300px');}
        delete select[$(this).attr('id')];
        counter--;
    }

    if (counter != 0) {
        $(".counter").css('opacity', '1');
    } else {
        $(".counter").css('opacity', '0');
    }

    document.getElementById("select-A").innerHTML = counter;
    document.getElementById("select-B").innerHTML = counter;
});


$('.delete').click(function () {
    var message;
    if (counter > 1) {
        message = 'Are you sure you want to delete these images?'
    } else {
        message = 'Are you sure you want to delete this image?'
    }

    var resp = confirm(message)
    if (resp == true) {

        for (var photo in select) {
            photo = select[photo].split("/")[1];
            $.ajax({
                url: '.delete.php',
                data: { 'file': photo },
                success: function (response) {
                    console.log("DELETE SUCCESS");
                    location.reload();
                    return false;
                },
                error: function () {
                    console.log("ERROR");
                }
            });
        }
    }


});


$('.download').click(function () {
    var link = document.createElement('a');


    link.style.display = 'none';

    document.body.appendChild(link);

    for (var photo in select) {
        link.setAttribute('download', select[photo].split("/")[1]);
        link.setAttribute('href', select[photo]);
        link.click();
    }

    document.body.removeChild(link);
});

$('.clear').click(function () {
    counter = 0;
    console.log(select)
    for (var photo in select) {

        $('#' + photo).css('border', '0px solid dodgerblue');
        $('#' + photo).css('width', '300px');
        delete select[photo];
    }

    $(".counter").css('opacity', '0');
    document.getElementById("select-A").innerHTML = counter;
    document.getElementById("select-B").innerHTML = counter;
});

$('#display').click(function (){
    var D = Number(document.querySelector('input[name="radio"]:checked').value);
    changeDisplay(D);
    
});


$('.option').click(function () {
    var attr = document.querySelector('input[name="platform"]:checked').value;
    
    setCookie('sort', attr, 2)
    attr = attr.split(" "); 
    sortPhotos(attr [0], attr [1]);
    
});


// Main
var counter = 0;
var select = {};
var data;
var state = getCookie('display');
var slider = document.getElementById("myRange");

var display = ['initial', '300px', '450px', 300, 450];
var sortOptions = ['A to Z', 'Z to A', 'Size', 'Rev-Size', 'Old to New', 'New to Old', 'Description']

slider.oninput = function() {
    display [1] = this.value + 'px';
    display [2] = (+this.value + +150) + 'px';
    display [3] = this.value;
    display [4] = this.value + 150;
    scale();
        
}

__init__(function(json_data){
    data = json_data;
    changeDisplay( getCookie('display') == null ? 0 : Number(getCookie('display'))  );
    S = getCookie('sort');
    if (S != null){
        S = S.split(" ");
        document.getElementById('selected-value').innerHTML = sortOptions [Number(S [2])];
        sortPhotos(S[0], S[1]);
    } 

    if (state == 0){
        $(".slidecontainer").css('opacity', '0');
    } else {
        $(".slidecontainer").css('opacity', '1');
    }
});





