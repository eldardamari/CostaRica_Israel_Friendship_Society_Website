$(document).ready(function() {

    $( "#winner_form_edit input" ).prop( "disabled", true ).css("background-color","LightGray");

    if($('#winner_form_edit .place').is(':checked')) {
        $( "#winner_form_edit input" ).css("background-color","");
        var rad = $('#winner_form_edit input[name=place]:checked').val();
        get_data_server(rad);
    }


    $('#winner_form_edit #year').change(function() {
    $( "#winner_form_edit input" ).prop( "disabled", true ).css("background-color","LightGray");

        $('div#preview').hide();

        init('','winners/'+get_contest_num()+'/');
        $("#winner_form_edit #year_pic").val(get_year_selected());

        $( "#winner_form_edit .place" ).prop( "disabled", false ); // show place radio
        empty_form();
    });   


    $("#winner_form_edit .place").change(function() {

        $( "#winner_form_edit input" ).css("background-color","");
        $( "#winner_form_edit #pictures" ).prop( "disabled", false ); // show Pictures

        init('','winners/'+get_contest_num()+'/');
        var place = $(this).val();
        get_data_server(place);
        $("#winner_form_edit #place_pic").val(place);
    });

    $("#winner_form_edit input[name='profile_pic']").change(function() {
        $('#winner_form_edit #file_profile')
        .text(this.files.length + " file selected");
    });
    $("#winner_form_edit input[name='pictures[]']").change(function() {
        $('#winner_form_edit #files_multi')
        .text(this.files.length + " file selected");
    });

    if (get_year_selected() == "Select Year..") {
        return;
    }
    else {
        $( "#winner_form_edit .place" ).prop( "disabled", false ); // show place radio
        $( "#winner_form_edit #year option:selected" )
            .each(function() {
                init('','winners/'+get_contest_num()+'/');
            });
    }
});
    
function get_data_server(place) { 
    var contest_num = get_contest_num();

        $.ajax({
            url : "utils/get_winners_form.php",
            type: "POST",
            data: {contest_num: contest_num , place: place},
            dataType: "json",
            success : function(data) {
                if(data)
                    update_form(data);
                else {
                    empty_form();
                    $( "#winner_form_edit input:not(.place)" ).prop( "disabled", true )
                    .css("background-color","LightGray");
                    if(confirm('Winner is not set, would you like to add new winner?')) {
                        location.href='http://israel-cr.org/edit_winners.php';
                    }
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
}
	
function update_form(res) {
    $("#winner_form_edit input[name=full_name]").val(res["name"]);
    $("#winner_form_edit input[name=email]")    .val(res["email"]);
    $("#winner_form_edit input[name=mobile]")   .val((res["tel_number"]));
    $("#winner_form_edit input[name=institute]").val(res["institute"]);
    $("#winner_form_edit input[name=subject]")  .val(res["subject"]);

    $("#winner_form_edit input" ).prop( "disabled", false );
}

function empty_form()
{
    $("#winner_form_edit input[name=place]").prop('checked', false)

    $("#winner_form_edit input[name=full_name]").val(null);
    $("#winner_form_edit input[name=email]")    .val(null);
    $("#winner_form_edit input[name=mobile]")   .val(null);
    $("#winner_form_edit input[name=institute]").val(null);
    $("#winner_form_edit input[name=subject]")  .val(null);
}
function get_contest_num() 
{
    return (String)(get_year_selected() - 2005);
}

function get_year_selected()
{
    return $("#winner_form_edit #year option:selected").val();
}
