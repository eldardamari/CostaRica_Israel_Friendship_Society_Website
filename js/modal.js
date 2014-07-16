var i = 1;
var amountOfImages = 0;
var path = "/costaRicaIsrael/img/";
var imagePath;

var path_array = new Array;
var index_array = new Array;
var amountOfImages_array = new Array;
var num_of_objects = 0;

function setIndex(index,num_of_object)
{
    index_array[num_of_object] = index;
    $('#image').html('<img class="bigImage" src="' + path_array[num_of_object]  
            +index_array[num_of_object]+'.jpg" />');
    $('#image').parent().removeClass();
    $('#image').parent().addClass(num_of_object.toString());
}

function toggleLeft()
{
    var num_of_object = parseInt($('#image').parent().attr('class'));
    if(index_array[num_of_object] > 1) {
        index_array[num_of_object]--;
    } else {
        index_array[num_of_object] = amountOfImages_array[num_of_object];
    }
    $('#image').html('<img class="bigImage" src="' + path_array[num_of_object]  
            +index_array[num_of_object]+'.jpg" />');
}

function toggleRight()
{
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
    if (type == "events") {
        imagePath = path + "events/events/" + eventId + "/";
    } else if (type == "meetings") {
        imagePath = path + "meetings/meetings/" + eventId + "/";
    } else if (type == "winners"){
        imagePath = path + "winners/" + eventId + "/";
    } else {
        $('.container').html("Error #10 - Event type is invalid.");
        return;
    }

    path_array[num_of_objects] = imagePath;
    index_array[num_of_objects] = 1;

    if (numOfImages == 0)
        return;

    /*alert("tbale = " + table +
            "\n type = " + type + 
            "\n eventId = " + eventId +
            "\n imagePath = " + imagePath +
            "\n numOfImages = " + numOfImages);*/

//    alert("Event Id = " + eventId + " | numOfImages = " + numOfImages);
    var container = $('<div />');

    for(var j = 1; j <= amountOfImages_array[num_of_objects]; j++) {
        $('<a />', {
            id:"david",
            href: "#openModal",
            onclick: "setIndex(" + j + "," + num_of_objects + ")",
            html: "<img class='thumb' src='"+ path_array[num_of_objects] + j +".jpg'>"
        }).appendTo(container);
    }
    //$('.imageTable').html(container);
    num_of_objects++;
    $(table).html(container);
}
