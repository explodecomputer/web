function windowWidth() {
	var myWidth = 0;
	if( typeof( window.innerWidth ) == 'number' ) {
		myWidth = window.innerWidth;
	} else if( document.documentElement && document.documentElement.clientWidth ) {
		myWidth = document.documentElement.clientWidth;
	} else if( document.body && document.body.clientWidth ) {
		myWidth = document.body.clientWidth;
	}
    return myWidth;
}

function windowPosition() {
	var scrOfX = 0
	if( typeof( window.pageXOffset ) == 'number' ) {
		scrOfX = window.pageXOffset;
	} else if( document.body && document.body.scrollLeft ) {
		scrOfX = document.body.scrollLeft;
	} else if( document.documentElement && document.documentElement.scrollLeft ) {
		scrOfX = document.documentElement.scrollLeft;
	}
    return scrOfX;
}


var delay = 5;
var scrollOffset = 25;

function goRight(targetXPos,lastPosition) {
    var x = windowPosition()+100;
    if(lastPosition == x) return false;
    if (x<targetXPos){
        window.scrollBy(scrollOffset, 0);
        timer = setTimeout('goRight('+targetXPos+','+x+')', delay);
    }
    else clearTimeout(timer);
    return false;
}

function goLeft(targetXPos,lastPosition) {
    var x = windowPosition()-100;
    if(lastPosition == x) return false;
    if (x>targetXPos){
        window.scrollBy(-scrollOffset, 0);
        timer = setTimeout('goLeft('+targetXPos+','+x+')', delay);
    }
    else clearTimeout(timer);
    return false;
}


function pageScrollRight() {
    var moveRight = windowPosition() + windowWidth();
	goRight(moveRight,-1);

}

function pageScrollLeft() {
    var moveLeft = windowPosition() - windowWidth();
    goLeft(moveLeft,-1);
}
