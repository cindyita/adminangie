<div class="d-flex justify-content-between align-items-center">
  <h3>Categorías</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newCategory">Nueva categoría</button>
</div>

<div id="onTable"></div>

<?php

$viewCategory = '<div id="viewCategory-content"></div>';
echo modal('viewCategory', 'Ver categoría', $viewCategory);

$newCategory = '<div>
                    <form method="post" id="newCategoryForm">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre de la categoría:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="type" class="form-label">Tipo de categoría:</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="P">Producto</option>
                                <option value="S">Service</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                        </div>
                    </form>
                </div>';
 echo modal('newCategory', 'Crear nueva categoría', $newCategory);

 $editCategory = '<div>
                    <form method="post" id="editCategoryForm">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre de la categoría:</label>
                            <input type="text" name="name" id="nameEdit" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="type" class="form-label">Tipo de categoría:</label>
                            <select class="form-select" name="type" id="typeEdit" required>
                                <option value="P">Producto</option>
                                <option value="S">Servicio</option>
                            </select>
                        </div>
                        <input type="hidden" name="id" id="idEdit">
                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Editar</button>
                        </div>
                    </form>
                </div>';
 echo modal('editCategory', 'Editar categoría', $editCategory);

  $deleteCategory = '<div>
                    <h5>¿Segur@ que quieres borrar la categoría con id: <span id="idDeleteText"></span>?</h5>
                    <form method="post" id="deleteCategoryForm">
                        <input type="hidden" name="id" id="idDelete">
                        <div class="w-100 d-flex justify-content-center pt-3">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </form>    
                </div>';
 echo modal('deleteCategory', 'Borrar categoría', $deleteCategory);