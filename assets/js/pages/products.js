$(function () {

    updateTable();

    $("#newProductForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#newProductForm")[0]);

        if ($("#img")[0].files[0]) {
            var file = $("#img")[0].files[0];
            formData.append('file', file);
        }

        sendAjaxForm(formData, 'CREATE').then(
            function (res) {
                console.log(res);
                if (processError(res)) {
                    message("El producto fue creado correctamente", "success");
                    $("#newProductForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#editProductForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#editProductForm")[0]);
        sendAjaxForm(formData, 'UPDATE').then(
            function (res) {
                if (processError(res)) {
                    message("El producto fue actualizado correctamente", "success");
                    $("#editProductForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#deleteProductForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#deleteProductForm")[0]);
        sendAjaxForm(formData, 'DELETE').then(
            function (res) {
                if (processError(res)) {
                    message("El producto fue eliminado correctamente", "success");
                    $("#deleteProductForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

});

function openModal(type,idModal,id) { 
    if (idModal == "Product") {
        if (type == "view") {
            $("#viewProduct-content").html("");
            $("#viewProduct-content").html('<div class="spinner-border"></div>');
            sendAjax({id:id}, 'SELECT').then(
                function (res) {    
                    data = JSON.parse(res);
                    data = data[0];
                    let contacto = data['id_contact'] ? `<a href="contacts/`+data['id_contact']+`">`+data['company']+`</a>` : '';
                    html = `<table class="table modalTable">
                                <tbody>
                                    <tr>
                                        <th>Imagen</th>
                                        <td><a href="`+data['img']+`" target="_blank"><img src="`+data['img']+`" onerror="this.src = './assets/img/system/user.avif'" loading="lazy" width="150px"></a></td>
                                    </tr>
                                    <tr>
                                        <th>Id</th>
                                        <td>`+data['id']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Nombre del producto</th>
                                        <td>`+data['name']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Categoría</th>
                                        <td>`+data['category']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Precio</th>
                                        <td>`+money(data['price'])+`</td>
                                    </tr>
                                    <tr>
                                        <th>Costo</th>
                                        <td>`+money(data['cost'])+`</td>
                                    </tr>
                                    <tr>
                                        <th>Margen de ganancia:</th>
                                        <td>`+money(data['margen'])+`</td>
                                    </tr>
                                    <tr>
                                        <th>Stock</th>
                                        <td>`+data['stock']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Disponibilidad:</th>
                                        <td>`+data['disponible']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Contacto relacionado:</th>
                                        <td>`+contacto+`</td>
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
                    $("#viewProduct-content").html(html);
                }).catch(function(error) {
                    console.error(error);
            });
        } else if (type == "edit") {
            sendAjax({id:id}, 'SELECT').then(
                function (res) { 
                    data = JSON.parse(res);
                    transposeDataEdit(data[0]);
                    $("#id_contact_inputEdit").val(data[0]['company']);
                    $("#imgText").html("");
                    $('#imgLink').attr('src', "");
                    $("#id_contact_inputEdit").addClass('orange');
                    if (data[0]['img_name']) {
                        $("#imgText").html(data[0]['img_name']);
                        $('#imgLink').attr('src', data[0]['img']);
                    }
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

