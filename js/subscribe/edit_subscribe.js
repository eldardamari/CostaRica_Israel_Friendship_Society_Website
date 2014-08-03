$(document).ready(function() {

    if($('.form_granted').length > 0){
        alert('Email send successfully! :)');
        location.reload();
    }

    $("#subscription_form_edit .type").change(function() {
        if( $(this).val() == 'newsletter' 
         || $(this).val() == 'bulletin')
             init('','documents/'+$(this).val()+'/');
    });
});
