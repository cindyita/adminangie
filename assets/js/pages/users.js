$(function () {

    getDataTable();
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
                        message("El usuario ha sido creado correctamente", "success");
                        $("#register")[0].reset();
                        updateTable();
                    }
                }).catch(function (error) {
                    message("Algo salió mal", "error");
                    console.error(error);
                });
        } else {
            message("Error en los campos","error");
        }
    });

    $("#editUserForm").on("submit", function (event) {
        event.preventDefault();
        var formData = new FormData($("#editUserForm")[0]);
        sendAjaxForm(formData, 'EDITUSER').then(
                function (res) {
                    console.log(res);
                    if (processError(res)) {
                        message("El usuario ha sido actualizado correctamente", "success");
                        $("#editUserForm")[0].reset();
                        updateTable();
                    }
                }).catch(function (error) {
                    message("Algo salió mal", "error");
                    console.error(error);
                });
    });
    $("#deleteUserForm").on("submit", function (event) {
        event.preventDefault();
        var formData = new FormData($("#deleteUserForm")[0]);
        sendAjaxForm(formData, 'DELETEUSER').then(
                function (res) {
                    console.log(res);
                    if (processError(res)) {
                        message("El usuario ha sido eliminado correctamente", "success");
                        $("#deleteUserForm")[0].reset();
                        updateTable();
                    }
                }).catch(function (error) {
                    message("Algo salió mal", "error");
                    console.error(error);
                });
    });
});
//Type Ejemplo: view,edit,delete. idModal ejemplo: User, id Ejemplo: 1,2,3
function openModal(type,idModal,id) { 
    if (idModal == "User") {
        if (type == "view") {
            $("#viewUser-content").html("");
            $("#viewUser-content").html('<div class="spinner-border"></div>');
            sendAjax({id:id}, 'viewUser').then(
                function (res) {    
                    data = JSON.parse(res);
                    html = `<table class="table modalTable">
                                <tbody>
                                    <tr>
                                        <th>Imagen</th>
                                        <td><img src="./assets/img/user/`+data['img']+`" onerror="this.src = './assets/img/system/user.avif'" loading="lazy" width="100px"></td>
                                    </tr>
                                    <tr>
                                        <th>Id</th>
                                        <td>`+data['id']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        <td>`+data['name']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>`+data['email']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Rol</th>
                                        <td>`+data['role']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Estatus</th>
                                        <td>`+data['estatus']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de creación</th>
                                        <td>`+data['timestamp_create']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Última actualización</th>
                                        <td>`+data['timestamp_update']+`</td>
                                    </tr>
                                </tbody>
                            </table>`;
                    $("#viewUser-content").html(html);
                }).catch(function(error) {
                    console.error(error);
            });
        } else if (type == "edit") {
            sendAjax({id:id}, 'viewUser').then(
                function (res) { 
                    data = JSON.parse(res);
                    $("#nameEdit").val(data['name']);
                    $("#emailEdit").val(data['email']);
                    $("#id_roleEdit").val(data['id_role']);
                    $("#statusEdit").val(data['status']);
                    $("#idEdit").val(data['id']);
                }).catch(function(error) {
                    console.error(error);
            });
        }else if (type == "delete") {
            $("#idDeleteText").html(id);
            $("#idDelete").val(id);
        }
        
    }
}

function updateTable() {
    getDataTable();
}

function getDataTable() {
    $("#onTable").html('Cargando tabla.. <div class="spinner-border"></div>');
    sendAjax({}, 'GET').then(
        function (res) {    
            data = JSON.parse(res);
            $("#onTable").html(data);
            initTable();
        }).catch(function(error) {
            console.error(error);
        });
}

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
