function eventsHeader() {
    document.write("\
                <tr class=\"table_header\" id='table_header' lang=\"en\">\
                    <th class=\"picCol\"></th>\
                    <th class=\"mnameCol\"></th>\
                    <th class=\"jobDesc\"></th>\
                    <th class=\"linkCol\"></th>\
                </tr>\
                <tr class=\"table_header\" lang=\"es\">\
                    <th class=\"picCol\"></th>\
                    <th class=\"mnameCol\"></th>\
                    <th class=\"jobDescCol\"></th>\
                    <th class=\"linkCol\"></th>\
                </tr>\
    ");
}


function open_abomePage(id) {
    document.location = "/costaRicaIsrael/aboutme.php?id="+id;
}

