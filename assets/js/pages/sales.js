$(function () {

    updateTable();

    $("#newSaleForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#newSaleForm")[0]);

        if ($("#img")[0].files[0]) {
            var file = $("#img")[0].files[0];
            formData.append('file', file);
        }

        sendAjaxForm(formData, 'CREATE').then(
            function (res) {
                console.log(res);
                if (processError(res)) {
                    message("La venta fue creada correctamente", "success");
                    $("#newSaleForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#editSaleForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#editSaleForm")[0]);
        sendAjaxForm(formData, 'UPDATE').then(
            function (res) {
                if (processError(res)) {
                    message("La venta fue actualizada correctamente", "success");
                    $("#editSaleForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#deleteSaleForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#deleteSaleForm")[0]);
        sendAjaxForm(formData, 'DELETE').then(
            function (res) {
                if (processError(res)) {
                    message("La venta fue eliminada correctamente", "success");
                    $("#deleteSaleForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

});

function openModal(type,idModal,id) { 
    if (idModal == "Sale") {
        if (type == "view") {
            $("#viewSale-content").html("");
            $("#viewSale-content").html('<div class="spinner-border"></div>');
            sendAjax({id:id}, 'SELECT').then(
                function (res) {    
                    data = JSON.parse(res);
                    data = data[0];
                    html = `<table class="table modalTable">
                                <tbody>
                                    <tr>
                                        <th>Id</th>
                                        <td>`+data['id']+`</td>
                                    </tr>
                                </tbody>
                            </table>`;
                    $("#viewSale-content").html(html);
                }).catch(function(error) {
                    console.error(error);
            });
        } else if (type == "edit") {
            sendAjax({id:id}, 'SELECT').then(
                function (res) { 
                    data = JSON.parse(res);
                    transposeDataEdit(data[0]);
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
