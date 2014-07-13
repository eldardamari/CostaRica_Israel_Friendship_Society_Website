var i = 1;
var amountOfImages = 3;     // TODO change the size to the amount from DB
var imagePath = "/costaRicaIsrael/img/event/";

function setIndex(index)
{
    i = index;
    $('#image').html('<img class="bigImage" src="' + imagePath  +i+'.jpg" />');
}

function toggleLeft()
{
    if(i > 1)
    {
        i--;
    $('#image').html('<img class="bigImage" src="' + imagePath  +i+'.jpg" />');
    }
}

function toggleRight()
{
    if(i < amountOfImages)
    {
        i++;
    $('#image').html('<img class="bigImage" src="' + imagePath  +i+'.jpg" />');
    }
}

function loadData(eventId , numOfImages) {
    amountOfImages = numOfImages;
    imagePath += eventId + "/";
    alert("Event Id = " + eventId + " | numOfImages = " + numOfImages);
    var container = $('<div />');

    for(var j = 1; j <= amountOfImages; j++) {
        $('<a />', {
            id: "id" + j,
            href: "#openModal",
            onclick: "setIndex(" + j + ")",
            html: "<img class='thumb' src='"+ imagePath + j +".jpg'>"
        }).appendTo(container);
    }

    $('.imageTable').html(container);
}
