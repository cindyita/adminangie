$(function () {

    updateTable();

    $("#newContactForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#newContactForm")[0]);
        sendAjaxForm(formData, 'CREATE').then(
            function (res) {
                if (processError(res)) {
                    message("El contacto fue creada correctamente", "success");
                    $("#newContactForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#editContactForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#editContactForm")[0]);
        sendAjaxForm(formData, 'UPDATE').then(
            function (res) {
                if (processError(res)) {
                    message("El contacto fue actualizada correctamente", "success");
                    $("#editContactForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#deleteContactForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#deleteContactForm")[0]);
        sendAjaxForm(formData, 'DELETE').then(
            function (res) {
                if (processError(res)) {
                    message("El contacto fue eliminado correctamente", "success");
                    $("#deleteContactForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

});

function openModal(type,idModal,id) { 
    if (idModal == "Contact") {
        if (type == "view") {
            $("#viewContact-content").html("");
            $("#viewContact-content").html('<div class="spinner-border"></div>');
            sendAjax({id:id}, 'SELECT').then(
                function (res) {    
                    data = JSON.parse(res);
                    html = `<table class="table modalTable">
                                <tbody>
                                    <tr>
                                        <th>Id</th>
                                        <td>`+data['id']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Empresa</th>
                                        <td>`+data['company']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Nombre del contacto</th>
                                        <td>`+data['name_contact']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Tipo de contacto</th>
                                        <td>`+data['tipo']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Producto/Servicio</th>
                                        <td>`+data['prod_serv']+`</td>
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
                    $("#viewContact-content").html(html);
                }).catch(function(error) {
                    console.error(error);
            });
        } else if (type == "edit") {
            sendAjax({id:id}, 'SELECT').then(
                function (res) { 
                    data = JSON.parse(res);
                    transposeDataEdit(data);
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
    $("#onTable").html('Cargando tabla.. <div class="spinner-border"></div>');
    sendAjax({}, 'GETTABLE').then(
        function (res) {
            data = JSON.parse(res);
            $("#onTable").html(data);
            initTable();
        }).catch(function(error) {
            console.error(error);
        });
}