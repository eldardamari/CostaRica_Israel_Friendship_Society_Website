var path = "/costaRicaIsrael/img/";
var imagePath;

var path_array = new Array;
var index_array = new Array;
var amountOfImages_array = new Array;
var num_of_objects = 0;

var modal = document.getElementsByClassName("openModal");

$(document).keydown(function(e) {
    var num_of_object = parseInt($('#image').parent().attr('class'));
    if (isNaN(num_of_object)) {
        return;
    }

  if(e.keyCode == 37) { // left
      toggleLeft();
  }
  else if(e.keyCode == 39) { // right
      toggleRight();
  }
});

function setIndex(index,num_of_object) {
    index_array[num_of_object] = index;
    $('#image').html('<img class="bigImage" src="' + path_array[num_of_object]  
            +index_array[num_of_object]+'.jpg" />');
    $('#image').parent().removeClass();
    $('#image').parent().addClass(num_of_object.toString());
}

function keyDown(e) {
    if (e.keyCode == 37) {
       alert( "left pressed" );
       return false;
    } else  if (e.keyCode == 39) {
       alert( "right key pressed" );
         return false;
    } else  if (e.keyCode == 38) {
       alert( "Up key pressed" );
         return false;
    } else  if (e.keyCode == 40) {
       alert( "Down key pressed" );
         return false;
    }
}

function toggleLeft() {
    var num_of_object = parseInt($('#image').parent().attr('class'));
    if(index_array[num_of_object] > 1) {
        index_array[num_of_object]--;
    } else {
        index_array[num_of_object] = amountOfImages_array[num_of_object];
    }
    $('#image').html('<img class="bigImage" src="' + path_array[num_of_object]  
            +index_array[num_of_object]+'.jpg" />');
}

function toggleRight() {
    var num_of_object = parseInt($('#image').parent().attr('class'));
    if(index_array[num_of_object] < amountOfImages_array[num_of_object]) {
        index_array[num_of_object]++;
    } else {
        index_array[num_of_object] = 1;
    }

    $('#image').html('<img class="bigImage" src="' + path_array[num_of_object]  
            +index_array[num_of_object]+'.jpg" />');
}

function loadData(table, type, eventId, numOfImages) {
    amountOfImages_array[num_of_objects] = numOfImages;
    /*amountOfImages = numOfImages;*/
    debugger;

    if (type == "events") {
        imagePath = path + "events/events/" + eventId + "/";
    } else if (type == "meetings") {
        imagePath = path + "events/meetings/" + eventId + "/";
    } else if (type == "winners") {
        imagePath = path + "winners/" + eventId + "/";
    } else {
        $('.container').html("Error #10 - Event type is invalid.");
        return;
    }

    path_array[num_of_objects] = imagePath;
    index_array[num_of_objects] = 1;

    if (numOfImages == 0)
        return;

    var container = $('<div />');
    for(var j = 1; j <= amountOfImages_array[num_of_objects]; j++) {
        $('<a />', {
            id:"david",
            href: "#openModal",
            onclick: "setIndex(" + j + "," + num_of_objects + ")",
            html: "<img class='thumb' src='"+ path_array[num_of_objects] + j +".jpg'>"
        }).appendTo(container);
    }
    num_of_objects++;
    $(table).html(container);
}

