$(function () {

    $("#email").on("focusout", function () {
        checkEmail();
    });

    $("#username").on("focusout", function () {
        checkUsername();
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
        var usernameValid = await checkUsername();
        var pass = checkPass();
        var cpass = checkCPass();
        var formData = new FormData($("#register")[0]);
        if (emailValid && usernameValid && pass && cpass) {
            sendAjaxForm(formData, 'REGISTER').then(
                function (res) {
                    message("You have successfully registered", "success");
                    $("#register")[0].reset();
                }).catch(function (error) {
                    message("Something went wrong", "error");
                    console.error(error);
            });
        } else {
            message("Error in fields","error");
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
            message("This email is already in use","error");
            $("#email").val("");
            return false;
        } else {
            return true;
        }
    } catch (error) {
        console.error(error);
        message("Something went wrong","error");
        return false;
    }
}

async function checkUsername() {
    var username = $("#username").val();
    try {
        var res = await sendAjax({ username: username }, 'CHECKUSERNAME');
        res = JSON.parse(res);
        if (res != "false") {
            console.log("Username error");
            message("This username is already in use","error");
            $("#username").val("");
            return false;
        } else {
            return true;
        }
    } catch (error) {
        console.error(error);
        message("Something went wrong","error");
        return false;
    }
}

function checkPass() {
    var pass = $("#pass").val();
    if (!checkPattern(pass)) {
        var msg = 'Password must contain:<ul>' +
            '<li>min 8 characters length</li>' +
            '<li>1 lower case letter</li>' +
            '<li>1 upper case letter</li>' +
            '<li>1 numeric character</li>' +
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
        message("Passwords must match","error");
        return false;
    }
    return true;
}

function checkPattern(str) {
    var reg = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    return reg.test(str);
}