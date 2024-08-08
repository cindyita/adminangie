<div class="d-flex justify-content-between align-items-center">
  <h3>Contactos</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newContact">Nuevo contacto</button>
</div>

<div id="onTable"></div>

<?php
$typeContact = "";
foreach ($typesContacts as $key => $value) {
    $typeContact .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}

$viewContact = '<div id="viewContact-content"></div>';
echo modal('viewContact', 'Ver categoría', $viewContact);

$newContact = '<div>
                    <form method="post" id="newContactForm">
                        <div class="mt-3">
                            <label for="company" class="form-label">Empresa:</label>
                            <input type="text" name="company" id="company" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="name_contact" class="form-label">Nombre del contacto:</label>
                            <input type="text" name="name_contact" id="name_contact" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="tel1" class="form-label">Teléfono 1:</label>
                            <input type="text" name="tel1" id="tel1" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="tel2" class="form-label">Teléfono 2:</label>
                            <input type="text" name="tel2" id="tel2" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="address" class="form-label">Dirección:</label>
                            <input type="text" name="address" id="address" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="rfc" class="form-label">RFC:</label>
                            <input type="text" name="rfc" id="rfc" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="id_type" class="form-label">Tipo de contacto:</label>
                            <select class="form-select" id="id_type" name="id_type" required>
                              '.$typeContact.'
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="prod_serv" class="form-label">Producto o servicio:</label>
                            <input type="text" name="prod_serv" id="prod_serv" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="extra_data" class="form-label">Datos extra:</label>
                            <textarea class="form-control" rows="3" name="extra_data" id="extra_data"></textarea>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                        </div>
                    </form>
                </div>';
 echo modal('newContact', 'Crear nueva categoría', $newContact);

 $editContact = '<div>
                    <form method="post" id="editContactForm">
                        <div class="mt-3">
                            <label for="company" class="form-label">Empresa:</label>
                            <input type="text" name="company" id="companyEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="name_contact" class="form-label">Nombre del contacto:</label>
                            <input type="text" name="name_contact" id="name_contactEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="tel1" class="form-label">Teléfono 1:</label>
                            <input type="text" name="tel1" id="tel1Edit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="tel2" class="form-label">Teléfono 2:</label>
                            <input type="text" name="tel2" id="tel2Edit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="address" class="form-label">Dirección:</label>
                            <input type="text" name="address" id="addressEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="rfc" class="form-label">RFC:</label>
                            <input type="text" name="rfc" id="rfcEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="id_type" class="form-label">Tipo de contacto:</label>
                            <select class="form-select" id="id_typeEdit" name="id_type" required>
                              '.$typeContact.'
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="prod_serv" class="form-label">Producto o servicio:</label>
                            <input type="text" name="prod_serv" id="prod_servEdit" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="extra_data" class="form-label">Datos extra:</label>
                            <textarea class="form-control" rows="3" name="extra_data" id="extra_dataEdit"></textarea>
                        </div>
                        <input type="hidden" name="id" id="idEdit">
                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Editar</button>
                        </div>
                    </form>
                </div>';
 echo modal('editContact', 'Editar contacto', $editContact);

$deleteContact = '<div>
                    <h5>¿Segur@ que quieres borrar el contacto con id: <span id="idDeleteText"></span>?</h5>
                    <form method="post" id="deleteContactForm">
                        <input type="hidden" name="id" id="idDelete">
                        <div class="w-100 d-flex justify-content-center pt-3">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </form>    
                </div>';
 echo modal('deleteContact', 'Borrar contacto', $deleteContact);