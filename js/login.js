function submitLogin(form, password) {
    debugger;

    $('<input>').attr({
        name: 'encryptedPassword',
        type: 'hidden',
        value: hex_sha512(password.value)
    }).appendTo(form);

    $(password).value = "";
}
