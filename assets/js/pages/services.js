$(function () {

    updateTable();

    $("#newServiceForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#newServiceForm")[0]);

        if ($("#img")[0].files[0]) {
            var file = $("#img")[0].files[0];
            formData.append('file', file);
        }

        sendAjaxForm(formData, 'CREATE').then(
            function (res) {
                console.log(res);
                if (processError(res)) {
                    message("El servicio fue creado correctamente", "success");
                    $("#newServiceForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#editServiceForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#editServiceForm")[0]);
        sendAjaxForm(formData, 'UPDATE').then(
            function (res) {
                if (processError(res)) {
                    message("El servicio fue actualizado correctamente", "success");
                    $("#editServiceForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#deleteServiceForm").on("submit", async function (event) {
        event.preventDefault();
        var formData = new FormData($("#deleteServiceForm")[0]);
        sendAjaxForm(formData, 'DELETE').then(
            function (res) {
                if (processError(res)) {
                    message("El servicio fue eliminado correctamente", "success");
                    $("#deleteServiceForm")[0].reset();
                    updateTable();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    flatpickr("#standby_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

});
let additions = 1;
let additionsEdit = 1;

function openModal(type,idModal,id) { 
    if (idModal == "Service") {
        if (type == "view") {
            $("#viewService-content").html("");
            $("#viewService-content").html('<div class="spinner-border"></div>');
            sendAjax({ id: id }, 'SELECT').then(
                function (res) {
                    data = JSON.parse(res);
                    data = data[0];
                    let contacto = data['id_contact'] ? `<a href="contacts/` + data['id_contact'] + `">` + data['company'] + `</a>` : '';
                    html = `<table class="table modalTable">
                                <tbody>
                                    <tr>
                                        <th>Imagen</th>
                                        <td><a href="`+ data['img'] + `" target="_blank"><img src="` + data['img'] + `" onerror="this.src = './assets/img/system/user.avif'" loading="lazy" width="150px"></a></td>
                                    </tr>
                                    <tr>
                                        <th>Id</th>
                                        <td>`+ data['id'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Nombre del servicio</th>
                                        <td>`+ data['name'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Categoría</th>
                                        <td>`+ data['category'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Precio</th>
                                        <td>$`+ money(data['price']) + `</td>
                                    </tr>
                                    <tr>
                                        <th>Costo</th>
                                        <td>$`+ money(data['cost']) + `</td>
                                    </tr>
                                    <tr>
                                        <th>Margen de ganancia:</th>
                                        <td>$`+ money(data['margen']) + `</td>
                                    </tr>
                                    <tr>
                                        <th>Tiempo de preparación</th>
                                        <td>`+ data['standby_days'] + ` Días, ` + data['standby_time'] + ` Horas</td>
                                    </tr>
                                    <tr>
                                        <th>Disponibilidad:</th>
                                        <td>`+ data['disponible'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Contacto relacionado:</th>
                                        <td>`+ contacto + `</td>
                                    </tr>
                                    <tr>
                                        <th>Descripción:</th>
                                        <td>`+ data['description'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Incluye:</th>
                                        <td>`+ data['includes'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Adiciones opcionales:</th>
                                        <td>`+ data['num_additions'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Usuario que registró</th>
                                        <td>`+ data['user'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de creación</th>
                                        <td>`+ data['timestamp_create'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Última actualización</th>
                                        <td>`+ data['timestamp_update'] + `</td>
                                    </tr>
                                </tbody>
                            </table>`;

                    sendAjax({ id: id }, 'SELECTADDITIONS').then(
                        function (res) {
                            data = JSON.parse(res);
                            let html2 =  '';
                            if (data[0]) {
                                html2 += `<hr><br><h4>Adiciones opcionales:</h4>
                                    <table class="table modalTable">
                                            <tbody>`;
                                html2 +=  `<tr>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Costo</th>
                                        </tr>`;
                                data.forEach(element => {
                                    html2 += `<tr>
                                                <th>`+element['name']+`</th>
                                                <td>$`+ money(element['price']) +`</td>
                                                <td>$`+money(element['cost'])+`</td>
                                            </tr>`;
                                });
                                html2 += `</tbody>
                                        </table>`;
                            }
                            $("#viewService-content").html(html);
                            $("#viewService-content").append(html2);
                            
                    }).catch(function(error) {
                    console.error(error);
                    });

                }).catch(function(error) {
                    console.error(error);
            });
        } else if (type == "edit") {
            sendAjax({id:id}, 'SELECT').then(
                function (res) { 
                    data = JSON.parse(res);
                    transposeDataEdit(data[0]);
                    $("#id_contact_inputEdit").val(data[0]['company']);
                    $("#id_contact_inputEdit").addClass('orange');
                    $("#imgText").html("");
                    $('#imgLink').attr('src', "");
                    if (data[0]['img_name']) {
                        $("#imgText").html(data[0]['img_name']);
                        $('#imgLink').attr('src', data[0]['img']);
                    }

                    sendAjax({ id: id }, 'SELECTADDITIONS').then(
                        function (res) {
                            data = JSON.parse(res);
                            if (data[0]) {
                                let html3 = '';
                                data.forEach(element => {
                                    html3 += `<div class="mb-1 edit_addition_`+additionsEdit+`">
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text"><i class="fa-solid fa-circle font-ultra-small"></i></span>
                                                    <input type="text" name="addition_`+additionsEdit+`" id="edit_addition_`+additionsEdit+`" class="form-control" placeholder="Nombre inventario/producto" value="`+element['name']+`">
                                                    <input type="number" name="additionPrice_`+additionsEdit+`" id="edit_additionPrice_`+additionsEdit+`" class="form-control" placeholder="Precio extra" value="`+element['price']+`">
                                                    <input type="number" name="additionCost_`+ additionsEdit + `" id="edit_additionCost_` + additionsEdit +`" class="form-control" placeholder="Costo extra" value="`+element['cost']+`">
                                                    <span class="input-group-text" onclick="deleteAdditionRowEdit(`+additionsEdit+`)"><i class="fa-solid fa-xmark text-danger cursor-pointer"></i></span>
                                                </div>
                                            </div>`;
                                    additionsEdit++;
                                });    
                                $("#additions_rowEdit").html(html3);
                                $("#num_additionsEdit").val(additionsEdit);
                            }
                    }).catch(function(error) {
                    console.error(error);
                    });

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


function addAdditionsRow() {
    let html = `<div class="mb-1 addition_`+additions+`">
            <div class="input-group mb-2">
                <span class="input-group-text"><i class="fa-solid fa-circle font-ultra-small"></i></span>
                <input type="text" name="addition_`+additions+`" id="addition_`+additions+`" class="form-control" placeholder="Nombre inventario/producto">
                <input type="number" name="additionPrice_`+additions+`" id="additionPrice_`+additions+`" class="form-control" placeholder="Precio extra">
                <input type="number" name="additionCost_`+ additions + `" id="additionCost_` + additions +`" class="form-control" placeholder="Costo extra">
                <span class="input-group-text" onclick="deleteAdditionRowEdit(`+additions+`)"><i class="fa-solid fa-xmark text-danger cursor-pointer"></i></span>
            </div>
        </div>`;
    $("#additions_row").append(html);
    additions++;
    $("#num_additions").val(additions);
}

function deleteAdditionRow(numAddition) {
    $(".addition_" + numAddition).remove();
    additions--;
    $("#num_additions").val(additions);
}

function addAdditionsRowEdit() {
    let html = `<div class="mb-1 edit_addition_`+additionsEdit+`">
            <div class="input-group mb-2">
                <span class="input-group-text"><i class="fa-solid fa-circle font-ultra-small"></i></span>
                <input type="text" name="addition_`+additionsEdit+`" id="edit_addition_`+additionsEdit+`" class="form-control" placeholder="Nombre inventario/producto">
                <input type="number" name="additionPrice_`+additionsEdit+`" id="edit_additionPrice_`+additionsEdit+`" class="form-control" placeholder="Precio extra">
                <input type="number" name="additionCost_`+ additionsEdit + `" id="edit_additionCost_` + additionsEdit +`" class="form-control" placeholder="Costo extra">
                <span class="input-group-text" onclick="deleteAdditionRow(`+additionsEdit+`)"><i class="fa-solid fa-xmark text-danger cursor-pointer"></i></span>
            </div>
        </div>`;
    $("#additions_rowEdit").append(html);
    additionsEdit++;
    $("#num_additionsEdit").val(additions);
}

function deleteAdditionRowEdit(numAddition) {
    $(".edit_addition_" + numAddition).remove();
    additionsEdit--;
    $("#num_additionsEdit").val(additionsEdit);
}