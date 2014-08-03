$(document).ready(function() {

    var str  = $('.text').text().charCodeAt(1);
    if (str > 1424 && str < 1535)
        $('.text').css("direction","rtl");

});

function eventsHeader() {
    document.write("\
                <tr class=\"table_header\" id='table_header' lang=\"en\">\
                    <th class=\"dateCol\"> Date </th>\
                    <th class=\"enameCol\"> Event Name</th>\
                    <th class=\"infoCol\"> Description </th>\
                    <th class=\"linkCol\"> Link </th>\
                </tr>\
                <tr class=\"table_header\" lang=\"es\">\
                    <th class=\"dateCol\"> Fecha </th>\
                    <th class=\"enameCol\"> Evento</th>\
                    <th class=\"infoCol\"> Descripción </th>\
                    <th class=\"linkCol\"> Vínculo </th>\
                </tr>\
    ");
}

function open_eventPage(e,id) {
    if(left_mouse_click(e))
        document.location = "/costaRicaIsrael/event.php?type=events&id="+id;
}

function open_meetingPage(e,id) {
    if(left_mouse_click(e))
        document.location = "/costaRicaIsrael/event.php?type=meetings&id="+id;
}

function left_mouse_click(e) {

     if (e.type != "mousedown") return false;

     if (e.which) { 
         if (e.which==3 || e.which==2) return false;
     }
     else if (e.button) {
         if (e.button==2 || e.button==4) return false;
     }
          return true;
}
