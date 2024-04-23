<div class="d-flex justify-content-between align-items-center">
  <h3>Productos</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newProduct">Nuevo producto</button>
</div>

<div id="onTable"></div>

<!----------Lists grands------------>
<datalist id="sug-data">
    <?php echo generateDatalist($contacts,"company"); ?>
</datalist>

<?php
$categoryProduct = "";
foreach ($categories as $key => $value) {
    $categoryProduct .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}

$viewProduct = '<div id="viewProduct-content"></div>';
echo modal('viewProduct', 'Ver Producto', $viewProduct);

$newProduct = '<div>
                    <form method="post" id="newProductForm">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="id_category" class="form-label">Categoría:</label>
                            <select class="form-select" id="id_category" name="id_category" required>
                              '.$categoryProduct.'
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="price" class="form-label">Precio:</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="cost" class="form-label">Costo:</label>
                            <input type="number" name="cost" id="cost" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="stock" class="form-label">Stock:</label>
                            <input type="number" name="stock" id="stock" class="form-control">
                        </div>
                        <div class="mt-3 position-relative">
                            <label for="id_contact" class="form-label">Contacto relacionado:</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-magnifying-glass icon-search"></i>
                                <input type="text" id="id_contact_input" class="form-control input-search" autocomplete="off" onfocus="intelligentSearch(\'id_contact\', \'id_contact_input\',\'sug-data\',\'id_contact_results\',3);" oninput="intelligentSearch(\'id_contact\', \'id_contact_input\',\'sug-data\',\'id_contact_results\',2);" onblur="notJustNumbers(this);hiddenResults(\'id_contact_results\');" placeholder="Escribe dos letras o más..">
                            </div>
                            <input type="hidden" name="id_contact" id="id_contact">
                            <div id="id_contact_results" class="contact_results d-none"></div>
                        </div>
                        <div class="mt-3">
                            <label for="sku" class="form-label">SKU:</label>
                            <input type="text" name="sku" id="sku" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="img" class="form-label">Imagen:</label>
                            <input type="file" name="img" id="img" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="availability" class="form-label">Disponibilidad:</label>
                            <select class="form-select" id="availability" name="availability" required>
                              <option value="1">Disponible</option>
                              <option value="0">No disponible</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="description" class="form-label">Descripción:</label>
                            <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                        </div>
                    </form>
                </div>';
 echo modal('newProduct', 'Crear nuevo producto', $newProduct);

$editProduct = '<div>
                    <form method="post" id="editProductForm">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="nameEdit" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="id_category" class="form-label">Categoría:</label>
                            <select class="form-select" id="id_categoryEdit" name="id_category" required>
                              '.$categoryProduct.'
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
                        <div class="mt-3 position-relative">
                            <label for="id_contact" class="form-label">Contacto relacionado:</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-magnifying-glass icon-search"></i>
                                <input type="text" id="id_contact_inputEdit" class="form-control input-search" autocomplete="off" onfocus="intelligentSearch(\'id_contactEdit\', \'id_contact_inputEdit\',\'sug-data\',\'id_contact_resultsEdit\',2);" oninput="intelligentSearch(\'id_contact\', \'id_contact_input\',\'sug-data\',\'id_contact_results\',3);" onblur="notJustNumbers(this);hiddenResults(\'id_contact_results\');" placeholder="Escribe dos letras o más..">
                            </div>
                            <input type="hidden" name="id_contact" id="id_contactEdit">
                            <div id="id_contact_resultsEdit" class="contact_results d-none"></div>
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
 echo modal('editProduct', 'Editar producto', $editProduct);

  $deleteProduct = '<div>
                    <h5>¿Segur@ que quieres borrar el producto con id: <span id="idDeleteText"></span>?</h5>
                    <form method="post" id="deleteProductForm">
                        <input type="hidden" name="id" id="idDelete">
                        <div class="w-100 d-flex justify-content-center pt-3">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </form>    
                </div>';
 echo modal('deleteProduct', 'Borrar producto', $deleteProduct);