$(document).ready(function() {

    var str  = $('.pMyMainInfo').text().charCodeAt(1);
    if (str > 1424 && str < 1535)
        $('.pMyMainInfo').css("direction","rtl");

});
