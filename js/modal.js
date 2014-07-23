var numOfTable = 0;
var amountOfImagesArray = new Array;

function setModalTable(numOfImages) {
    numOfTable++;
    amountOfImagesArray[numOfTable] = numOfImages;
}

$(document).keydown(function(e) {

  if(e.keyCode == 37) { // left
      toggleLeft();
  }
  else if(e.keyCode == 39) { // right
      toggleRight();
  } else if (e.keyCode == 27) {
      window.open('#close', '_self', '');
  }

});

function showModal(image,id) {
    $('#image').html('<img class="bigImage" src="' + image + ' " />');
    $('#image').removeClass();
    $('#image').addClass(id);
}

function toggleLeft() {
    var id =$('#image').attr('class');
    var splitId = id.split("_");
    var tableId = splitId[0];
    var prevId = parseInt(splitId[1]) - 1;

    if(prevId < 1)
        prevId = amountOfImagesArray[tableId];

    var src = $('#' + tableId + "_" + prevId).attr('src');
    $('#image').html('<img class="bigImage" src="' + src + ' " />');
    $('#image').removeClass();
    $('#image').addClass(tableId + "_" + prevId);
}

function toggleRight() {
    var id = $('#image').attr('class');
    var splitId = id.split("_");
    var tableId = splitId[0];
    var nextId = parseInt(splitId[1]) + 1;

    if(nextId > amountOfImagesArray[tableId])
        nextId = 1;

    var src = $('#' + tableId + "_" + nextId).attr('src');
    $('#image').html('<img class="bigImage" src="' + src + ' " />');
    $('#image').removeClass();
    $('#image').addClass(tableId + "_" + nextId);
}
