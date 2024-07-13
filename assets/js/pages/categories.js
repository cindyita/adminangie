$(function () {

    updateTable();

    $("#newCategoryForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#newCategoryForm")[0]);
        sendAjaxForm(formData, 'CREATE').then(
            function (res) {
                if (processError(res)) {
                    message("La categoría fue creada correctamente", "success");
                    $("#newCategoryForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#editCategoryForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#editCategoryForm")[0]);
        sendAjaxForm(formData, 'UPDATE').then(
            function (res) {
                if (processError(res)) {
                    message("La categoría fue actualizada correctamente", "success");
                    $("#editCategoryForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#deleteCategoryForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#deleteCategoryForm")[0]);
        sendAjaxForm(formData, 'DELETE').then(
            function (res) {
                if (processError(res)) {
                    message("La categoría fue eliminada correctamente", "success");
                    $("#deleteCategoryForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

});

function openModal(type,idModal,id) { 
    if (idModal == "Category") {
        if (type == "view") {
            $("#viewCategory-content").html("");
            $("#viewCategory-content").html('<div class="spinner-border"></div>');
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
                                        <th>Categoría</th>
                                        <td>`+data['name']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Tipo</th>
                                        <td>`+data['tipo']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Usuario que registró</th>
                                        <td>`+data['user']+` (id: `+data['id_user']+`)</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de creación</th>
                                        <td>`+data['FechaCreado']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Última actualización</th>
                                        <td>`+(data['FechaActualizado'] ?? '')+`</td>
                                    </tr>
                                </tbody>
                            </table>`;
                    $("#viewCategory-content").html(html);
                }).catch(function(error) {
                    console.error(error);
            });
        } else if (type == "edit") {
            sendAjax({id:id}, 'SELECT').then(
                function (res) { 
                    data = JSON.parse(res);
                    $("#nameEdit").val(data['name']);
                    $("#typeEdit").val(data['type']);
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