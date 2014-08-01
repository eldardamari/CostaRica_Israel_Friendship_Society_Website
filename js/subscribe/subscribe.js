$(document).ready(function() {

    $(".general_form").submit(function(){
        if(!$(".general_form input:checked").length) {
                alert("Please check at least one checkbox");
            return false; } });


    $('.publications button').click(function() {
        var stat = $(this).attr('id');
        var table = $(this).closest('table').attr('id');
        get_data_server(table,$(this).val(),stat);
    });

    $('.publications > :not(tfoot) > tr').click(function() {
        var table = $(this).closest('table').attr('id');
        table =         table.substring(0,table.indexOf('_'));
        var file_name = $(this).data("filename");
        if(file_name)
            document.location = "/costaRicaIsrael/img/documents/"+table+"/"+file_name;
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
                else {
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
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

function update_table(table,res,stat) {

    table = '#'+table;
    var end = (res.length < 6 ? true : false);

    $(table).find("tbody tr:gt(0)").remove();
    $(table).append("<tbody></tbody>");

  for(i=0 ; i < 6; i++) {
      if(res.length == 1 && i == 0) {
          $(table).append( '<tr><td colspan=2>' + res[0]["year"]  + ' ' + res[0]["month"] + ' (' + res[0]["catalog"] + ')</td></tr>' );
          continue;
      }
      if(i >= res.length)
          $(table).append('<tr><td colspan=2></td></tr>');
      else
          $(table).append( '<tr><td colspan=2>' + res[i]["year"]  + ' ' + res[i]["month"] + ' (' + res[i]["catalog"] + ')</td></tr>' );
  }

  var next = $(table + ' #next');
  var prev = $(table + ' #prev');

    if(stat == "next") {
        if(end)
            next.attr('disabled',true);
        else
            next.attr('disabled',false);
        prev.attr('disabled',false);
        next.val(parseInt(next.val(),10) + 6);
        prev.val(parseInt(prev.val(),10) + 6);
    } else {
        if(prev.val() != 0) {
            next.attr('disabled',false);
            prev.attr('disabled',false);
        } else {
            prev.attr('disabled',true);
        }
        prev.val(parseInt(prev.val(),10) - 6);
        next.val(parseInt(next.val(),10) - 6);
    }
}
