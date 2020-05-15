var inputRange = document.getElementsByClassName('range')[0],
    maxValue = 300, // the higher the smoother when dragging
    speed = 5,
    currValue, rafID
    ranges = [(maxValue-50)/5, (maxValue-50)/5*2, (maxValue-50)/5*3];

// set min/max value
inputRange.min = 50;
inputRange.max = maxValue;

// listen for unlock
function unlockStartHandler() {
    // clear raf if trying again
    window.cancelAnimationFrame(rafID);
    
    // set to desired value
    currValue = +this.value;
}

function unlockEndHandler() {
    
    // store current value
    currValue = +this.value;
    
    // determine if we have reached success or not
    if(currValue >= maxValue) {
        successHandler();
    }
    else {
        rafID = window.requestAnimationFrame(animateHandler);
    }
}

// handle range animation
function animateHandler() {

    // calculate gradient transition
    var transX = currValue - maxValue;
    
    // update input range
    inputRange.value = currValue;

    //Change slide thumb color on mouse up
    if (currValue < ranges [0]) {
        inputRange.classList.remove('ltpurple');
    }
    if (currValue < ranges [1]) {
        inputRange.classList.remove('purple');
    }
    if (currValue < ranges [2]) {
        inputRange.classList.remove('pink');
    }
    
    // determine if we need to continue
    if(currValue > -1) {
      window.requestAnimationFrame(animateHandler);   
    }
    
    // decrement value
    currValue = currValue - speed;
}


// move gradient
inputRange.addEventListener('input', function() {
    //Change slide thumb color on way up
    if (this.value > ranges [0]) {
        inputRange.classList.add('ltpurple');
    }
    if (this.value > ranges [1]) {
        inputRange.classList.add('purple');
    }
    if (this.value > ranges [2]) {
        inputRange.classList.add('pink');
    }

    //Change slide thumb color on way down
    if (this.value < ranges [0]) {
        inputRange.classList.remove('ltpurple');
    }
    if (this.value < ranges [1]) {
        inputRange.classList.remove('purple');
    }
    if (this.value < ranges [2]) {
        inputRange.classList.remove('pink');
    }
});