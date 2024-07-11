$(function () {
    
    $("#login").on("submit", function (event) {
        event.preventDefault();
        var formData = new FormData($("#login")[0]);
        if ($("#email").val() != "" && $("#pass").val() != "") {
            sendAjaxForm(formData, 'LOGIN').then(
                function (res) { 
                    console.log(res);
                    if (processError(res)) {
                        message("Has iniciado sesión correctamente", "success");
                        $("#login")[0].reset();
                        window.location.href = "home";
                    }
                }).catch(function (error) {
                    message("Algo salió mal", "error");
                    console.error(error);
            });
        } else {
            message("Debes llenar todos los campos","error");
        }
    });

});