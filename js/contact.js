$(document).ready(function() {

    $('.general_form').on('click', '#contact_btn', function(e){
        setTimeout(function() {
            $('#contact_btn').prop( "disabled", true);
        }, 100);
    });
});
