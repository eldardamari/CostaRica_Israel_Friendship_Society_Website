$(document).ready(function() {

    // hebrew text support
    var str  = $('.text').text().charCodeAt(1);
    if (str > 1424 && str < 1535)
        $('.text').css("direction","rtl");
    
    // title
    $(document).prop('title', $(".events_tablesName").text().slice(0,-10));
});
