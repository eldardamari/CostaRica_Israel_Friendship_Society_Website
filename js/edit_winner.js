$(document).ready(function() {

    $( "input" ).prop( "disabled", true ).css("background-color","LightGray");

    if($('.place').is(':checked')) {
        /*var check = $(".place").prop("checked");*/
        $( "input" ).css("background-color","");
        var rad = $('input[name=place]:checked', '#winner_form').val();
        get_data_server(rad);
    } else {
    }


    $('#year').change(function() {
    $( "input" ).prop( "disabled", true ).css("background-color","LightGray");

        $('div#preview').hide();
        var val = $("#year option:selected").val();
        var contest_num = (String)(val - 2005);

        init('','winners/'+contest_num+'/');
        $("#year_pic").val(val);
        var x = $("#year_pic").val();


        $( ".place" ).prop( "disabled", false ); // show place radio
        empty_form();
    });   


    $(".place").change(function() {

        $( "input" ).css("background-color","");
        $( "#pictures" ).prop( "disabled", false ); // show Pictures
        var val = $("#year option:selected").val();
        var contest_num = (String)(val - 2005);

        init('','winners/'+contest_num+'/');
        var val1 = $(this).val();
        get_data_server(val1);
        $("#place_pic").val(val1);
    });

    $("input[name='profile_pic']").change(function() {
        $('#file_profile').text(this.files.length + " file selected");
    });
    $("input[name='pictures[]']").change(function() {
        $('#files_multi').text(this.files.length + " file selected");
    });

        /*$( "#year option:selected" ).each(function() {
            init('','winners/'+contest_num+'/'); // set browser window
        });*/
    var val = $("#year option:selected").val();
    if (val == "Select Year..") {
        return;
    }
    else {
        $( ".place" ).prop( "disabled", false ); // show place radio
        /*empty_form();*/
        var contest_num = (String)(val - 2005);

        $( "#year option:selected" ).each(function() {
            init('','winners/'+contest_num+'/');
        });
    }
});
    
function get_data_server(place) { 
    var val = $("#year option:selected").val();
    var contest_num = (String)(val - 2005);

        $.ajax({
            url : "utils/get_winners_form.php",
            type: "POST",
            data: {contest_num: contest_num , place: place},
            dataType: "json",
            success : function(data) {
                if(data)
                    update_form(data);
                else
                    empty_form();
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
}
	
function update_form(res) {
    $("input[name=full_name").val(res["name"]);
    $("input[name=email").val(res["email"]);
    $("input[name=mobile").val((0+res["tel_number"]));
    $("input[name=institute").val(res["institute"]);
    $("input[name=subject").val(res["subject"]);
    $( "input" ).prop( "disabled", false );
}

/*$(function() {
    var val = $("#year option:selected").text();
    if (val == "Select Year..")
        return;
    var contest_num = (String)(val - 2005);
    $( "#year option:selected" ).each(function() {
        init('','winners/'+contest_num+'/');
    });
});*/

function empty_form()
{
    $("input[name=place]").prop('checked', false)
    $("input[name=full_name]").val(null);
    $("input[name=email]").val(null);
    $("input[name=mobile]").val(null);
    $("input[name=institute]").val(null);
    $("input[name=subject]").val(null);
}
