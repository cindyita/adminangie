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
                    clearSaleTable();
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
                    let html = `<table class="table modalTable">
                                <tbody>
                                    <tr>
                                        <th>Id</th>
                                        <td>`+data['id']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Referencia</th>
                                        <td>`+data['num_invoice']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Vendedor</th>
                                        <td>`+data['name_seller']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Productos</th>
                                        <td>`+data['num_products']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>$`+money(data['total'])+`</td>
                                    </tr>
                                    <tr>
                                        <th>Método de pago</th>
                                        <td>`+data['payment_method']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha</th>
                                        <td>`+data['sale_date']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Notas</th>
                                        <td>`+data['notes']+`</td>
                                    </tr>
                                    <tr>
                                        <th>Usuario que registró</th>
                                        <td>`+data['user']+` (id: `+data['id_user']+`)</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de creación</th>
                                        <td>`+ data['timestamp_create'] + `</td>
                                    </tr>
                                    <tr>
                                        <th>Última actualización</th>
                                        <td>`+(data['timestamp_update'] ?? '')+`</td>
                                    </tr>
                                </tbody>
                            </table>`;

                    sendAjax({id:id}, 'SELECTPRODUCTS').then(
                        function (res) { 
                            data = JSON.parse(res);
                            let html2 = '';
                            if (data[0]) {
                                html2 += `<hr><br><h4>Productos:</h4>
                                    <table class="table modalTable">
                                            <tbody>`;
                                data.forEach(element => {
                                    html2 += `<tr>
                                                <th>`+element['name']+`</th>
                                                <td>$`+money(element['price'])+`</td>
                                            </tr>`;
                                });
                                html2 += `</tbody>
                                        </table>`;
                            }
                            $("#viewSale-content").html(html);
                            $("#viewSale-content").append(html2);
                            
                    }).catch(function(error) {
                    console.error(error);
                    });
                    
                }).catch(function(error) {
                    console.error(error);
                });
            
        } else if (type == "edit") {
            $("#infoSaleEdit").html('<div class="spinner-border spinner-border-sm"></div>');
            sendAjax({id:id}, 'SELECT').then(
                function (res) { 
                    data = JSON.parse(res);
                    let html = `<div>Id: ` + data[0]['id'] + `<br>
                                Productos: ` + data[0]['num_products'] + `<br>
                                Total: $` + money(data[0]['total']) + `</div>`;
                    $("#infoSaleEdit").html(html);
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
let products = 1;                                               
function addProductsRow() {
    html = `<div class="productrow_`+products+`">
                <div class="d-flex gap-2 w-100 align-items-center mb-2 position-relative">
                    <div class="input-group nowrap position-relative">

                        <input type="text" id="product_`+products+`" class="form-control input-search-r" placeholder="Buscar producto" autocomplete="off" 
                        
                        onfocus="intelligentSearchQuery(\'id_product_`+products+`\', \'product_`+products+`\',\'sug_results_`+products+`\',3);"

                        oninput="intelligentSearchQuery(\'id_product_`+products+`\', \'product_`+products+`\',\'sug_results_`+products+`\',3);" 
                        
                        onblur="notJustNumbers(this);hiddenResults(\'sug_results_`+ products +`\');">
                        
                        <input type="hidden" id="id_product_`+ products + `" name="id_product_` + products +`" class="id-product-data">
                        
                        <div id="sug_results_`+products+`" class="sug-results d-none"></div>

                        <i class="fa-solid fa-magnifying-glass icon-search-r"></i>

                        <input type="number" name="nums_`+ products + `" id="nums_` + products + `" class="form-control w-25 flexnone product-cant-data" value="1" placeholder="Cantidad" min="0" oninput="this.value = Math.abs(this.value);calculateTotal(` + products + `);" onblur="calculateTotal(` + products +`);" step="1">

                        <span class="input-group-text" onclick="deleteProductRow(`+products+`)"><i class="fa-solid fa-xmark text-danger cursor-pointer"></i></span>
                    </div>

                    <div class="d-flex gap-3 ms-3">
                        <h5>
                            $<span class="product_price">-</span>
                        </h5>
                        <h5>|</h5>
                        <h5>
                            $<span class="product_subtotal">-</span>
                        </h5>
                    </div>
                    
                </div>
            </div>`;
    $("#sales-products-row").append(html);
    products++;
}

function deleteProductRow(products) {
    $(".productrow_" + products).remove();
    products--;
    calculateTotal();
}

function clearSaleTable() {
    $("#newSaleForm")[0].reset();
    $("#sales-products-row").html(`<div>
                                <div class="d-flex gap-2 w-100 align-items-center mb-2 position-relative">
                                    <div class="input-group nowrap position-relative">
    
                                        <input type="text" id="product_1" class="form-control input-search-r" placeholder="Buscar producto" autocomplete="off" 
                                        
                                        onfocus="intelligentSearchQuery('id_product_1', 'product_1','sug_results',3);"

                                        oninput="intelligentSearchQuery('id_product_1', 'product_1','sug_results',3);" 
                                        
                                        onblur="notJustNumbers(this);hiddenResults('sug_results');">

                                        <input type="hidden" id="id_product_1" name="id_product_1" class="id-product-data">

                                        <div id="sug_results" class="sug-results d-none"></div>

                                        <i class="fa-solid fa-magnifying-glass icon-search-r"></i>

                                        <input type="number" name="nums_1" id="nums_1" class="form-control w-25 flexnone product-cant-data" value="1" placeholder="Cantidad" min="0" oninput="this.value = Math.abs(this.value);calculateTotal(1);" onblur="calculateTotal(1);" step="1">
                                    </div>

                                    <div class="d-flex gap-3 ms-3">
                                        <h5>
                                            $<span class="product_price">-</span>
                                        </h5>
                                        <h5>|</h5>
                                        <h5>
                                            $<span class="product_subtotal">-</span>
                                        </h5>
                                    </div>
                                    
                                </div>
                            </div>`);
    $("#sale-total").html("0");
    $("#total_num_products").val("");
    $("#sale-total-input").val("");
    $("#num_products_text").html("0");
}


function intelligentSearchQuery(idInputHidden, idInputText, idSugDataResults = 'sug-data-results', numMinWords = 3) {
    console.log("searching");
    
  $("#"+idInputText).removeClass('orange');
  $("#"+idInputHidden).val("");

  const searchText = $("#"+idInputText).val().toLowerCase();

    if (searchText != "" && searchText.length >= numMinWords) {

      $("#" + idSugDataResults).removeClass('d-none');
      $("#" + idSugDataResults).html('<div class="spinner-border spinner-border-sm"></div>');
      
      sendAjax({text:searchText}, 'INTELLIGENTSEARCH').then(
        function (res) {
          data = JSON.parse(res);
          if (data) {
            $("#" + idSugDataResults).html('');
            let optionText = '';
            let optionId = '';
            let price = 0;
            data.forEach(element => {
              optionText = element['name'];
              optionId = element['id'];
              price = element['price'];
              $("#" + idSugDataResults).append($("<div onclick='searchDataResultsOptionQuery(" + optionId + ",\"" + optionText + "\",\"" + idInputText + "\", \"" + idInputHidden + "\", \"" + idSugDataResults + "\","+price+")'>").html('<div class="option-result py-2 px-3">' + optionText + ' [$'+price+']</div>'));
            });
          } else {
            $("#" + idSugDataResults).html('');
            // $("#"+idSugDataResults).addClass('d-none');
            }
            $("#" + idSugDataResults).append($("<div onclick='searchAllProductsQuery(\"" + idInputText + "\", \"" + idInputHidden + "\", \"" + idSugDataResults + "\")'>").html('<div class="option-result py-2 px-3 text-secondary">Ver todos los productos <i class="fa-solid fa-magnifying-glass"></i></div>'));
            
        }).catch(function(error) {
            console.error(error);
        });

    }
    $("#" + idSugDataResults).html('');
    $("#" + idInputHidden).val($("#" + idInputText).val());
}

function searchAllProductsQuery(idInputText2, idInputHidden2, idSugDataResults2) {

    stopHiddenResults = 1;

    $("#" + idSugDataResults2).html('<div class="spinner-border spinner-border-sm"></div>');

    sendAjax({}, 'ALLPRODUCTSSEARCH').then(
        function (res2) {
          var data2 = JSON.parse(res2);
          if (data2) {
            $("#" + idSugDataResults2).html('');
            let optionText2 = '';
            let optionId2 = '';
            let price2 = 0;
            data2.forEach(element => {
                console.log(element);
                optionText2 = element['name'];
                optionId2 = element['id'];
                price2 = element['price'];
                $("#" + idSugDataResults2).append($("<div onclick='searchDataResultsOptionQuery(" + optionId2 + ",\"" + optionText2 + "\",\"" + idInputText2 + "\", \"" + idInputHidden2 + "\", \"" + idSugDataResults2 + "\","+price2+")'>").html('<div class="option-result py-2 px-3">' + optionText2 + ' [$'+price2+']</div>'));
            });
          } else {
            $("#"+idSugDataResults2).append('No se encontraron los productos');
          }
            
        }).catch(function(error) {
            console.error(error);
        });
}

function searchDataResultsOptionQuery(optionId, optionText, idInputText, idInputHidden, idSugDataResults, price) {

    stopHiddenResults = 0;
    $("#"+idSugDataResults).empty();
    $("#"+idSugDataResults).addClass('d-none');
    $("#"+idInputText).val(optionText);
    $("#"+idInputHidden).val(optionId);
    $("#" + idInputText).addClass('orange');
    $("#" + idInputHidden).data("price", price);

    calculateTotal();
}

function calculateTotal() {
  let total = 0;
  let numProducts = 0;
  $(".id-product-data").each(function(index, element) {
    let price = parseFloat($(element).data("price"));
    let cant = parseInt($(".product-cant-data").eq(index).val());

    if (!isNaN(price) && !isNaN(cant)) {
      $(".product_price").eq(index).html(price);
      $(".product_subtotal").eq(index).html(price*cant);
      total += price * cant;
      numProducts += cant;
    }
  });

  $("#sale-total").html(money(total));
  $("#sale-total-input").val(total);
  $("#num_products_text").html(numProducts);
  $("#total_num_products").val(numProducts);
}