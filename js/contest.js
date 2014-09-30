$(document).ready(function() {
    
$("#paypal_form input").prop("disabled", true);
$("#paypal_form :input").prop("disabled", true);

    $("#paypal_form").submit(function() {

	


        $("#paypal_form input[name=active_pay]").val("true");
        if($("#paypal_form input[name=hosted_button_id]").val() == "A9TGAAGBZ5WEU") {
        }
        else {
            alert("Problem with payment.. please try again");
        }
    });
});


function eventsHeader() {
    document.write("\
                <tr class=\"table_header\" id='table_header' lang=\"en\">\
                    <th class=\"place\"></th>\
                    <th class=\"pic\"></th>\
                    <th class=\"wname\"></th>\
                    <th class=\"major\"></th>\
                    <th class=\"uni\"></th>\
                </tr>\
                <tr class=\"table_header\" lang=\"es\">\
                    <th class=\"place\"></th>\
                    <th class=\"pic\"></th>\
                    <th class=\"wname\"></th>\
                    <th class=\"major\"></th>\
                    <th class=\"uni\"></th>\
                </tr>\
    ");
}

function validateDate()
{
    var birthDate = document.getElementById('bDate').value;

    if (Date.parse(birthDate) > Date.now()) {
        document.getElementById('bDate').style.background = "#FAA59E";
    }
    else
        document.getElementById('bDate').style.background = "#ECFFEC";
}


