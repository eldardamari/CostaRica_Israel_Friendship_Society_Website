function line(date,ename,desc,link) {
    this.date = date;
    this.ename = ename;
    this.desc = desc;
    this.link = link;
}

line1 = new line("1/1/2014","event1 "   ,"Example 1","see more");
line2 = new line("1/1/2014","event2 "   ,"Example 2","see more");
line3 = new line("1/1/2014","event3"    ,"Example 3","see more");
line4 = new line("1/1/2014","event4"    ,"Example 4","see more");

var data = new Array();
data.push(line1); data.push(line2);
data.push(line3); data.push(line4);


function insertDataToTable(table_name) {
    var gTable  = document.getElementById(table_name);
    {
        for(var i = 0 ; i < data.length ; i++) {
            var rowlength = gTable.rows.length;
            var row     = gTable.insertRow(rowlength);
            row.onmousedown = function mDown() {
                /*document.location = "http://" + this.cells[3].innerHTML;*/
                document.location = "/costaRicaIsrael/event.html";
            };
            var line = data[i];
            row.alt = "click for more info";
            row.insertCell(0).innerHTML = line.date;
            row.insertCell(1).innerHTML = line.ename;
            row.insertCell(2).innerHTML = line.desc;
            row.insertCell(3).innerHTML = line.link;
        }
    }
}

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
