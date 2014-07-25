$(document).ready(function() {
    $("#winner_form_add input[name='profile_pic']").change(function() {
        $('#winner_form_add #file_profile')
        .text(this.files.length + " file selected");
    });
    $("#winner_form_add input[name='pictures[]']").change(function() {
        $('#winner_form_add #files_multi')
        .text(this.files.length + " file selected");
    });

});

