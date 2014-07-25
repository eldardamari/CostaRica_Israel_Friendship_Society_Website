
if(!localStorage.getItem("lang")) {
    document.body.className = 'en';
    localStorage.setItem("lang", 'en');
} else {
    document.body.className = localStorage.getItem("lang");
}

function setLanguage(l) {
    document.body.className = l;
    localStorage.setItem("lang", l);
}

$(window).scroll(function(){

    var scrollVar = $(window).scrollTop();
    $('#main_header').css({'opacity':( 100-scrollVar )/100});
    if($('#main_header').css('opacity') < 0.4)
        $("#main_header").css({cursor: "default", display:"none"});
    else 
        $("#main_header").css({cursor: "pointer", display:"inline"});
});
