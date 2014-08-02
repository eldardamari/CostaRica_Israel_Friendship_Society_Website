$(document).ready(function() {

    $(".general_form").submit(function(){
        if(!$(".general_form input:checked").length) {
                alert("Please check at least one checkbox");
            return false; } });


    $('.publications tfoot td').click(function() {
        var page = $(this).data('page');
        var table = $(this).closest('table').attr('id');
        var state = $(this).closest('td').attr('id');
        get_data_server(table,page,state);
    });
    
    $('.publications ').on('click', '.pub_row', function(){
        download_file($(this));
    });

    $('.publications :not(tfoot) tr').click(function() {
        download_file($(this));
    });
});

function get_data_server(table,row,stat) { 

        $.ajax({
            url : "utils/get_subscriptions_data.php",
            type: "POST",
            data: {table: table.substring(0,table.indexOf('_')) , row: row},
            dataType: "json",
            success : function(data) {
                if(data)
                    update_table(table,data,stat);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
}

function update_table(table,res,stat) {

    table = '#'+table;
    var end = (res.length < 6 ? true : false);

    $(table).find("tbody tr").remove();
 
    for(i=0 ; i < 6; i++) {
      if(res.length == 1 && i == 0) {
          $(table).append('<tr class="pub_row" data-filename="' + res[0]["file_name"] + '"><td colspan=2 > <img src="./img/icons/doc.png" height="22" width="22"> ' + res[0]["year"]  + ' ' + get_month(res[0]["month"]) + ' (' + res[0]["catalog"] + ')</td></tr>');
          continue;
      }
      if(i >= res.length)
          $(table).append('<tr><td colspan=2></td></tr>');
      else{
          $(table).append('<tr class="pub_row" data-filename="' + res[i]["file_name"] + '"><td colspan=2 > <img src="./img/icons/doc.png" height="22" width="22"> ' + res[i]["year"]  + ' ' + get_month(res[i]["month"]) + ' (' + res[i]["catalog"] + ')</td></tr>');
      }
  }
  
  var next = $(table + ' #next');
  var prev = $(table + ' #prev');
  var next_val = parseInt(next.data("page"),10);
  var prev_val = parseInt(prev.data("page"),10);

    if(stat == "next") {
        if(end)
            next.css("opacity","0.2");
        else
            next.css("opacity","1");
        prev.css("opacity","1");
        next.data("page",next_val + 6);
        prev.data("page",prev_val + 6);
    } else {
        if(prev_val != 0) {
            prev.css("opacity","1");
        } else {
            prev.css("opacity","0.2");
        }
            next.css("opacity","1");
        next.data("page",next_val - 6);
        prev.data("page",prev_val - 6);
    }
}

function get_month(number) {
    switch(parseInt(number,10)) {
    case 1: return  "January";  break;
    case 2: return  "February"; break;
    case 3: return  "March";    break;
    case 4: return  "April";    break;
    case 5: return  "May";      break;
    case 6: return  "June";     break;
    case 7: return  "July";     break;
    case 8: return  "August";   break;
    case 9: return  "September"; break;
    case 10: return "October";  break;
    case 11: return "November"; break;
    case 12: return "December"; break;
    default: "ma";
    }
}

function download_file(selector) {
        var table = $(selector).closest('table').attr('id');
        table =  table.substring(0,table.indexOf('_'));
        var file_name = $(selector).data("filename");
        if(file_name)
            document.location = "/costaRicaIsrael/img/documents/"+table+"/"+file_name;
}

function publicationsHeader() {
    document.write("\
                <tr class=\"table_header\" id='table_header' lang=\"en\">\
                    <th class=\"dateCol\"> Date </th>\
                </tr>\
                <tr class=\"table_header\" lang=\"es\">\
                    <th class=\"dateCol\"> Fecha </th>\
                    <th class=\"enameCol\"> Evento</th>\
                    <th class=\"infoCol\"> Descripción </th>\
                    <th class=\"linkCol\"> Vínculo </th>\
                </tr>\
    ");
}

