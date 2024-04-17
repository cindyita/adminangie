$(function () {

    $("#email").on("focusout", function () {
        checkEmail();
    });

    $("#pass").on("focusout", function () {
        checkPass();
    });

    $("#cpass").on("focusout", function () {
        checkCPass();
    });

    $("#register").on("submit", async function (event) {
        event.preventDefault();
        var emailValid = await checkEmail();
        var pass = checkPass();
        var cpass = checkCPass();
        var formData = new FormData($("#register")[0]);
        if (emailValid && pass && cpass) {
            sendAjaxForm(formData, 'REGISTER').then(
                function (res) {
                    if (processError(res)) {
                        message("Te has registrado correctamente", "success");
                        $("#register")[0].reset();
                        var myModal = bootstrap.Modal.getInstance($('#newUser'));
                        myModal.hide();
                    }
                }).catch(function (error) {
                    message("Algo salió mal", "error");
                    console.error(error);
            });
        } else {
            message("Error en los campos","error");
        }
    });

});

async function checkEmail() {
    var email = $("#email").val();
    try {
        var res = await sendAjax({ email: email }, 'CHECKEMAIL');
        res = JSON.parse(res);
        if (res != "false") {
            console.log("Email error");
            message("Este email ya está en uso","error");
            $("#email").val("");
            return false;
        } else {
            return true;
        }
    } catch (error) {
        console.error(error);
        message("Algo salió mal","error");
        return false;
    }
}

function checkPass() {
    var pass = $("#pass").val();
    if (!checkPattern(pass)) {
        var msg = 'La contraseña debe contener:<ul>' +
            '<li>Longitud mínima de 8 caracteres</li>' +
            '<li>1 letra minúscula</li>' +
            '<li>1 letra mayúscula</li>' +
            '<li>1 número</li>' +
            '</ul>';
        message(msg, "error");
        return false;
    }
    return true;
}

function checkCPass() {
    var pass = $("#pass").val();
    var cpass = $("#cpass").val();
    if (pass != cpass) {
        message("Las contraseñas deben coincidir","error");
        return false;
    }
    return true;
}

function checkPattern(str) {
    var reg = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    return reg.test(str);
}