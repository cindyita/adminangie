<div class="d-flex justify-content-between align-items-center">
  <h3>Servicios</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newService">Nuevo servicio</button>
</div>

<div id="onTable"></div>

<!----------Lists grands------------>
<datalist id="sug-data">
    <?php echo generateDatalist($contacts,"company"); ?>
</datalist>

<?php
$categoryService = "";
foreach ($categories as $key => $value) {
    $categoryService .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}

$viewService = '<div id="viewService-content"></div>';
echo modal('viewService', 'Ver Servicio', $viewService, 'lg');

$newService = '<div>
                    <form method="post" id="newServiceForm">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="id_category" class="form-label">Categoría:</label>
                            <select class="form-select" id="id_category" name="id_category" required>
                              '.$categoryService.'
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="price" class="form-label">Precio base:</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="cost" class="form-label">Costo:</label>
                            <input type="number" name="cost" id="cost" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="standby_days" class="form-label">Tiempo de preparación (Días):</label>
                            <input type="number" name="standby_days" id="standby_days" class="form-control" step="1">
                        </div>
                        <div class="mt-3">
                            <label for="standby_time" class="form-label">Tiempo de preparación (Horas,Minutos):</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-clock icon-search"></i>
                                <input type="time" name="standby_time" id="standby_time" class="form-control" step="60">
                            </div>
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
                            <textarea class="form-control" rows="2" name="description" id="description"></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="includes" class="form-label">El servicio incluye:</label>
                            <textarea class="form-control" rows="3" name="includes" id="includes" placeholder="Lista de inventario que el servicio incluye"></textarea>
                        </div>

                        <div class="mt-3">
                            <div class="mb-3 d-flex align-items-center gap-2">
                              <label for="additions" class="form-label">Adiciones opcionales:</label>
                              <a class="btn btn-primary" onclick="addAdditionsRow()"><i class="fa-solid fa-plus"></i></a>
                            </div>
                            <input type="hidden" name="num_additions" id="num_additions" value="0">
                            <div id="additions_row"></div>
                        </div>
                        <hr>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                        </div>
                    </form>
                </div>';
 echo modal('newService', 'Crear nuevo servicio', $newService,'lg');

$editService = '<div>
                    <form method="post" id="editServiceForm">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="nameEdit" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="id_category" class="form-label">Categoría:</label>
                            <select class="form-select" id="id_categoryEdit" name="id_category" required>
                              '.$categoryService.'
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
                            <label for="standby_days" class="form-label">Tiempo de preparación (Días):</label>
                            <input type="number" name="standby_days" id="standby_daysEdit" class="form-control" step="1">
                        </div>
                        <div class="mt-3">
                            <label for="standby_time" class="form-label">Tiempo de preparación (Horas,Minutos):</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-clock icon-search"></i>
                                <input type="time" name="standby_time" id="standby_timeEdit" class="form-control" step="60">
                            </div>
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
                            <label for="includes" class="form-label">El servicio incluye:</label>
                            <textarea class="form-control" rows="3" name="includes" id="includesEdit" placeholder="Lista de inventario que el servicio incluye"></textarea>
                        </div>

                        <div class="mt-3">
                            <div class="mb-3 d-flex align-items-center gap-2">
                              <label for="additions" class="form-label">Adiciones opcionales:</label>
                              <a class="btn btn-primary" onclick="addAdditionsRowEdit()"><i class="fa-solid fa-plus"></i></a>
                            </div>
                            <input type="hidden" name="num_additions" id="num_additionsEdit" value="0">
                            <div id="additions_rowEdit"></div>
                        </div>
                        <hr>
                        <div class="mt-3">
                            <input type="hidden" id="idEdit" name="id">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Editar</button>
                        </div>
                    </form>
                </div>';
 echo modal('editService', 'Editar servicio', $editService,'lg');

  $deleteService = '<div>
                    <h5>¿Segur@ que quieres borrar el servicio con id: <span id="idDeleteText"></span>?</h5>
                    <form method="post" id="deleteServiceForm">
                        <input type="hidden" name="id" id="idDelete">
                        <div class="w-100 d-flex justify-content-center pt-3">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </form>    
                </div>';
 echo modal('deleteService', 'Borrar servicio', $deleteService);