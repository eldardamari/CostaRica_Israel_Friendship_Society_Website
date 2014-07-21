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

function open_eventPage(id) {
    document.location = "/costaRicaIsrael/event.php?type=events&id="+id;
}

function open_meetingPage(id) {
    document.location = "/costaRicaIsrael/event.php?type=meetings&id="+id;
}