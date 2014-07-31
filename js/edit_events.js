$(document).ready(function () {
    $('#editEventForm input').prop('disabled', true);
    $('#editEventForm textarea').prop('disabled', true);

    $('select').on('change', function() {
        $('#imagePreview').css('display', 'none');
        $('#previewName').html("");
        $('#action').prop('name','').css('visibility' , 'hidden');
        $('#deleteEvent').val(this.value).show();

        $('#editEventForm #files_multi').text("");
        $('#editEventForm input').prop('disabled', false);
        $('#editEventForm textarea').prop('disabled', false);

        var eventType = $('#eventType').val().toLowerCase() + 's';
        var base = 'events/' + eventType + '/' + this.value + '/';

        $.ajax({
            url : "utils/get_event.php",
            type: "POST",
            data: "id=" + this.value + "&eventType=" + eventType,
            dataType: "json",
            success : function(result) {

                $('#editEventName').val(result.name);
                $('#editDate').val(result.date);
                $('#editDescription').html(result.description);
                $('#editText').html(result.text);

                init($('#eventType').val(),base);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
                alert(status);
                alert(error);
            }
        });

    });

    $("input[name='pictures[]']").change(function() {
        $('#editEventForm #files_multi').text(this.files.length + " file selected");
        $('#addEventForm #files_multi').text(this.files.length + " file selected");
    });


    $('#deleteEvent').click(function(e) {

        if(!confirm('Are you sure you want to delete event?\n'+
                    'All data will be lost!')) {
                e.preventDefault();
                    }
    });


});


