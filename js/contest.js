function line(pic,wname,major) {
    this.picPath = pic;
    this.wname = wname;
    this.major = major;
}

line1 = new line("./img/1.jpg"   ,"Might Baby" ,"CEO"  ,"02-4738374<br> baby@bab.com");
line2 = new line("./img/2.jpg"   ,"Old Oldios" ,"CTO"  ,"03-4343424<br> old@old.com");
line3 = new line("./img/3.jpg"   ,"Biz Man"    ,"ISO"  ,"05-3232323<br> ma@ma.com");
line4 = new line("./img/4.jpg"   ,"Dude Smile" ,"IT"   ,"07-3123124<br> smile@smile.com");

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
                document.location = "http://" + this.cells[3].innerHTML;
            };
            var line = data[i];
            row.alt = "click for more info";
            row.insertCell(0).innerHTML = "<img id='myPic' src='" + line.picPath + "' height:'100' width='100'/>";
            row.insertCell(1).innerHTML = line.mname;
            row.insertCell(2).innerHTML = line.desc;
            row.insertCell(3).innerHTML = line.link;
        }
    }
}

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
