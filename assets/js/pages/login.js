$(function () {
    
    $("#login").on("submit", function (event) {
        event.preventDefault();
        var formData = new FormData($("#login")[0]);
        if ($("#email").val() != "" && $("#pass").val() != "") {
            sendAjaxForm(formData, 'LOGIN').then(
                function (res) { 
                    console.log(res);
                    if (processError(res)) {
                        message("You have logged in successfully", "success");
                        $("#login")[0].reset();
                        window.location.href = "home";
                    }
                }).catch(function (error) {
                    message("Something went wrong", "error");
                    console.error(error);
            });
        } else {
            message("You must fill out the fields","error");
        }
    });

});