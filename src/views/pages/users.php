
<div class="d-flex justify-content-between align-items-center">
  <h3>Usuarios</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newUser">Nuevo usuario</button>
</div>

<div id="onTable"></div>

<?php 
    $rol = "";
    foreach ($roles as $key => $value) {
        $rol .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }

    $newUser = '<div>
                    <form method="post" id="register">
                        <div class="mt-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="pass" class="form-label">Contraseña:</label>
                            <input type="password" name="pass" id="pass" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="cpass" class="form-label">Confirmación de contraseña:</label>
                            <input type="password" id="cpass" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="id_role" class="form-label">Rol de usuario:</label>
                            <select class="form-select" id="id_role" name="id_role" required>
                                '.$rol.'
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="status" class="form-label">Estatus:</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                        </div>
                    </form>
                </div>';
 echo modal('newUser', 'Crear nuevo usuario', $newUser);

 $viewUser = '<div id="viewUser-content"></div>';
 echo modal('viewUser', 'Ver usuario', $viewUser);

$editUser = '<div>
                <form method="post" id="editUserForm">
                    <div class="mt-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" name="name" id="nameEdit" class="form-control" required>
                    </div>
                    <div class="mt-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="emailEdit" class="form-control" required>
                    </div>
                    <div class="mt-3">
                        <label for="id_role" class="form-label">Rol de usuario:</label>
                        <select class="form-select" name="id_role" id="id_roleEdit" required>
                            '.$rol.'
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="status" class="form-label">Estatus:</label>
                        <select class="form-select" name="status" id="statusEdit" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" id="idEdit">
                    <div class="mt-3">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Editar</button>
                    </div>
                </form>
            </div>';
 echo modal('editUser', 'Editar usuario', $editUser);

 $deleteUser = '<div>
                    <h5>¿Segur@ que quieres borrar al usuario con id: <span id="idDeleteText"></span>?</h5>
                    <form method="post" id="deleteUserForm">
                        <input type="hidden" name="id" id="idDelete">
                        <div class="w-100 d-flex justify-content-center pt-3">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </form>    
                </div>';
 echo modal('deleteUser', 'Borrar usuario', $deleteUser);
?>