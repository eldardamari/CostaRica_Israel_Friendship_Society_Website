function line(pic,wname,major,uni) {
    this.picPath = pic;
    this.wname  = wname;
    this.major  = major;
    this.uni    = uni;
}

line1 = new line("1st", "./img/1.jpg"   ,"Jhon Snow"  ,"Computer Science","BGU");
line2 = new line("2nd", "./img/2.jpg"   ,"Ayra Stark" ,"Engineering","TAU");

var data = new Array();
data.push(line1); data.push(line2);

function insertDataToTable(table_name) {
    var gTable  = document.getElementById(table_name);
    alert(table_name);
    {
        for(var i = 0 ; i < data.length ; i++) {
            var rowlength   = gTable.rows.length;
            var row         = gTable.insertRow(rowlength);
            };
            var line = data[i];
            row.insertCell(0).innerHTML = "1st";
            row.insertCell(1).innerHTML = "<img id='myPic' src='" + line.picPath + "' height:'100' width='100'/>";
            row.insertCell(2).innerHTML = line.wname;
            row.insertCell(3).innerHTML = line.major;
            row.insertCell(4).innerHTML = line.uni;
        }
    }
}

function eventsHeader() {
    document.write("\
                <tr class=\"table_header\" id='table_header' lang=\"en\">\
                    <th class=\"place\"></th>\
                    <th class=\"wname\"></th>\
                    <th class=\"major\"></th>\
                    <th class=\"uni\"></th>\
                </tr>\
                <tr class=\"table_header\" lang=\"es\">\
                    <th class=\"place\"></th>\
                    <th class=\"wname\"></th>\
                    <th class=\"major\"></th>\
                    <th class=\"uni\"></th>\
                </tr>\
    ");
}

function validateDate()
{
    alert("!@!@");
    var birthDate = document.getElementById('bDate').value;

    if (Date.parse(birthDate) > Date.now()) {
        document.getElementById('bDate').style.background = "#FAA59E";
    }
    else
        document.getElementById('bDate').style.background = "#ECFFEC";
}
