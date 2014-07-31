$(document).ready(function() {
    $("#add_member_form input[name='profile_pic']").change(function() {
        $('#add_member_form #file_profile')
        .text(this.files.length + " file selected");
    });
});

