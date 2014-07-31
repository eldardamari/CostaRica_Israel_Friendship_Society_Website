$(document).ready(function() {

    $( "#edit_member_form input" ).prop( "disabled", true ).css("background-color","LightGray");
    $( "#edit_member_form textarea" ).prop( "disabled", true ).css("background-color","LightGray");


    $('#edit_member_form #select_memeber').change(function() {
        $( "#edit_member_form input" ).prop( "disabled", false ).css("background-color","");
        $( "#edit_member_form textarea" ).prop( "disabled", false ).css("background-color","");
        var userId = $(this).val();
        get_data_server(userId);
        if(userId != 0)
            $('#deleteMember').val(this.value).show();
    });   

    $('#deleteMember').click(function(e) {

        if(!confirm('Are you sure you want to delete memeber?\n'+
                    'All data on memeber will be lost!')) {
                e.preventDefault();
                    }
    });
    
    $('#edit_member_form [type=reset]').click(function() {
        $( "#edit_member_form input" ).prop( "disabled", true ).css("background-color","LightGray");
        $( "#edit_member_form textarea" ).prop( "disabled", true ).css("background-color","LightGray");
    });


    $("#edit_member_form input[name='profile_pic']").change(function() {
        $('#edit_member_form #file_profile')
        .text(this.files.length + " file selected");
    });
});
    
function get_data_server(userId) { 

        $.ajax({
            url : "utils/get_member_data.php",
            type: "POST",
            data: {user_id: userId},
            dataType: "json",
            success : function(data) {
                if(data)
                    update_form(data);
                else {
                    empty_form();
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
}
	
function update_form(res) {
    $("#edit_member_form input[name=full_name]").val(res["name"]);
    $("#edit_member_form input[name=email]")    .val(res["email"]);
    $("#edit_member_form input[name=position]") .val(res["position"]);
    $("#edit_member_form input[name=mobile]")   .val(res["tel_number"]);
    $("#edit_member_form textarea[name=title]")    .val(res["title"]);
    $("#edit_member_form textarea[name=about_me]") .val(res["aboutme_text"]);

    $("#edit_member_form input" ).prop( "disabled", false );
}

function empty_form() {
    $("#edit_member_form input[name=full_name]").val(null);
    $("#edit_member_form input[name=email]")    .val(null);
    $("#edit_member_form input[name=position]") .val(null);
    $("#edit_member_form input[name=mobile]")   .val(null);
    $("#edit_member_form textarea[name=title]")    .val(null);
    $("#edit_member_form textarea[name=about_me]") .val(null);
}

function get_member_id_selected() {
    return $("#edit_member_form #select_memeber option:selected").val();
}
