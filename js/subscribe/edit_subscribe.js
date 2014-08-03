$(document).ready(function() {

    if($('.email_sent').length > 0){
        alert('Email send successfully! :)');
        location.reload();
    }
    
    if($('.document_added').length > 0){
        alert('Document uploaded successfully! :)');
        location.reload();
    }

    $("#subscription_form_edit .type").change(function() {
        if( $(this).val() == 'newsletter' 
         || $(this).val() == 'bulletin')
             init('','documents/'+$(this).val()+'/');
    });
});
