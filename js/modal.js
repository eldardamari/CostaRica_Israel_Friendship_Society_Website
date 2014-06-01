var i = 1;
var amountOfImages = 3;     // TODO change the size to the amount from DB

function setIndex(index)
{
    i = index;
    $("#image").html("<img class='bigImage' src='/costaRicaIsrael/img/event/"+i+".jpg' />");
}

function toggleLeft()
{
    if(i > 1)
    {
        i--;
        $("#image").html("<img class='bigImage' src='/costaRicaIsrael/img/event/"+i+".jpg' />");
    }
}

function toggleRight()
{
    if(i < amountOfImages)
    {
        i++;
        $("#image").html("<img class='bigImage' src='/costaRicaIsrael/img/event/"+i+".jpg' />");
    }
}