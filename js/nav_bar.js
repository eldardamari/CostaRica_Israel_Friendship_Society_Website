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
