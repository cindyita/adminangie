<div class="d-flex justify-content-between align-items-center">
  <h3>Ventas</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSale">Nueva venta</button>
</div>

<div id="onTable"></div>

<?php

$viewSale = '<div id="viewSale-content"></div>';
echo modal('viewSale', 'Ver Venta', $viewSale,"lg");

$methods = createSelectOptions($payment_methods,'name','id');

$newSale = '<div>
                <form method="post" id="newSaleForm">
                    <hr>
                    <div class="mt-3 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <h5>Productos: (<span id="num_products_text">0</span>)</h5>
                                <a class="btn btn-primary" onclick="addProductsRow()"><i class="fa-solid fa-plus"></i></a>
                            </div>
                            <div>Precio U. | Subtotal</div>
                        </div>
                        <div id="sales-products-row">
                        
                        </div>
                        
                    </div>

                    <div>
                        <h3><strong>Total:</strong> $<span class="ms-2" id="sale-total">0</span></h3>
                        <input type="hidden" name="num_products" id="total_num_products" value="0">
                        <input type="hidden" name="total" id="sale-total-input">
                    </div>

                    <hr>
                    <div class="mt-3">
                        <label for="id_seller" class="form-label">Vendedor:</label>
                        <input type="text" name="name_seller" id="name_seller" class="form-control" value="'.$_SESSION['MYSESSION']['name'].'">
                    </div>
                    
                    <div class="mt-3">
                        <label for="date" class="form-label">Fecha de la venta:</label>
                        <input type="date" name="sale_date" id="date" class="form-control" value="'.DATE.'">
                    </div>
                    <div class="mt-3">
                        <label for="id_payment_method" class="form-label">Método de pago:</label>
                        <select class="form-select" id="id_payment_method" name="id_payment_method" required>
                            '.$methods.'
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="notes" class="form-label">Notas:</label>
                        <textarea class="form-control" rows="2" name="notes" id="notes"></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="num_invoice" class="form-label">Folio o referencia:</label>
                        <input type="text" name="num_invoice" id="num_invoice" class="form-control">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                    </div>
                </form>
            </div>';
 echo modal('newSale', 'Crear nueva venta', $newSale,"lg");

$editSale = '<div>
                <div id="infoSaleEdit"></div>
                <form method="post" id="editSaleForm">
                    <div class="mt-3">
                        <label for="id_seller" class="form-label">Vendedor:</label>
                        <input type="text" name="name_seller" id="name_sellerEdit" class="form-control">
                    </div>
                    
                    <div class="mt-3">
                        <label for="date" class="form-label">Fecha de la venta:</label>
                        <input type="date" name="sale_date" id="sale_dateEdit" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label for="id_payment_method" class="form-label">Método de pago:</label>
                        <select class="form-select" id="id_payment_methodEdit" name="id_payment_method" required>
                            '.$methods.'
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="notes" class="form-label">Notas:</label>
                        <textarea class="form-control" rows="3" name="notes" id="notesEdit"></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="num_invoice" class="form-label">Folio o referencia:</label>
                        <input type="text" name="num_invoice" id="num_invoiceEdit" class="form-control">
                    </div>
                    <div class="mt-3">
                        <input type="hidden" id="idEdit" name="id">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Editar</button>
                    </div>
                </form>
            </div>';
 echo modal('editSale', 'Editar venta', $editSale,"lg");

  $deleteSale = '<div>
                    <h5>¿Segur@ que quieres borrar la venta con id: <span id="idDeleteText"></span>?</h5>
                    <form method="post" id="deleteSaleForm">
                        <input type="hidden" name="id" id="idDelete">
                        <div class="w-100 d-flex justify-content-center pt-3">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </form>    
                </div>';
 echo modal('deleteSale', 'Borrar venta', $deleteSale);