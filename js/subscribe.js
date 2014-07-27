$(document).ready(function() {

    $(".general_form").submit(function(){
        if(!$(".general_form input:checked").length) {
                alert("Please check at least one checkbox");
            return false; } });
});
