<div class="d-flex justify-content-between align-items-center">
  <h3>Ventas</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSale">Nueva venta</button>
</div>

<div id="onTable"></div>

<?php

$viewSale = '<div id="viewSale-content"></div>';
echo modal('viewSale', 'Ver Saleo', $viewSale);

$newSale = '<div>
                <form method="post" id="newSaleForm">
                    <hr>
                    <div class="mt-3 p-3">
                        <h5>Productos:</h5>
                        <div>
                          <div class="d-flex gap-2 w-100 align-items-center">
                            <div>Producto 1:</div>
                            <div class="d-flex w-75"><input type="text" class="form-control"></div>
                            <a class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
                          </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <label for="num_products" class="form-label">Cantidad:</label>
                        <input type="number" name="num_products" id="num_products" class="form-control" disabled>
                    </div>
                    <div class="mt-3">
                        <label for="num_invoice" class="form-label">Folio:</label>
                        <input type="text" name="num_invoice" id="num_invoice" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label for="id_payment_method" class="form-label">Método de pago:</label>
                        <select class="form-select" id="id_payment_method" name="id_payment_method" required>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="bank" class="form-label">Banco (Opcional):</label>
                        <input type="text" name="bank" id="bank" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label for="id_seller" class="form-label">Vendedor:</label>
                        <select class="form-select" id="id_seller" name="id_seller" required>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="availability" class="form-label">Estatus:</label>
                        <select class="form-select" id="availability" name="availability" required>
                          <option value="1">Exitoso</option>
                          <option value="2">En espera</option>
                          <option value="0">Cancelado</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="fecha" class="form-label">Fecha de la venta:</label>
                        <input type="datetime-local" name="fecha" id="fecha" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label for="notes" class="form-label">Notas:</label>
                        <textarea class="form-control" rows="3" name="notes" id="notes"></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="name_client" class="form-label">Nombre del cliente (Opcional):</label>
                        <input type="text" name="name_client" id="name_client" class="form-control">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                    </div>
                </form>
            </div>';
 echo modal('newSale', 'Crear nueva venta', $newSale,"lg");

$editSale = '<div>
                    <form method="post" id="editSaleForm">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="nameEdit" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="id_category" class="form-label">Categoría:</label>
                            <select class="form-select" id="id_categoryEdit" name="id_category" required>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="price" class="form-label">Precio:</label>
                            <input type="number" name="price" id="priceEdit" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="cost" class="form-label">Costo:</label>
                            <input type="number" name="cost" id="costEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="stock" class="form-label">Stock:</label>
                            <input type="number" name="stock" id="stockEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="sku" class="form-label">SKU:</label>
                            <input type="text" name="sku" id="skuEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="img" class="form-label">Imagen:</label>
                            <img src="" width="30px" id="imgLink">
                            <span id="imgText"></span>
                            <input type="file" name="img" id="img" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="availability" class="form-label">Disponibilidad:</label>
                            <select class="form-select" id="availabilityEdit" name="availability" required>
                              <option value="1">Disponible</option>
                              <option value="0">No disponible</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="description" class="form-label">Descripción:</label>
                            <textarea class="form-control" rows="3" name="description" id="descriptionEdit"></textarea>
                        </div>
                        <div class="mt-3">
                            <input type="hidden" id="idEdit" name="id">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Editar</button>
                        </div>
                    </form>
                </div>';
 echo modal('editSale', 'Editar venta', $editSale);

  $deleteSale = '<div>
                    <h5>¿Segur@ que quieres borrar la venta con id: <span id="idDeleteText"></span>?</h5>
                    <form method="post" id="deleteSaleForm">
                        <input type="hidden" name="id" id="idDelete">
                        <div class="w-100 d-flex justify-content-center pt-3">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </form>    
                </div>';
 echo modal('deleteSale', 'Borrar Saleo', $deleteSale);