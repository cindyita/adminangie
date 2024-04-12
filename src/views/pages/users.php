
<div class="d-flex justify-content-between align-items-center">
  <h3>Usuarios</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newUser">Nuevo usuario</button>
</div>

<div id="onTable"></div>

<?php 
  $newUser = '<div>
                <form action="/action_page.php">
                  <div class="mb-3 mt-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="name" placeholder="Ingresa el nombre" name="name">
                  </div>
                  <div class="mb-3 mt-3">
                    <label for="name" class="form-label">Nombre de usuario:</label>
                    <input type="text" class="form-control" id="name" placeholder="Ingresa el nombre" name="name">
                  </div>
                  <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                  </div>
                  <div class="mb-3">
                    <label for="pwd" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
                  </div>
                  <div class="form-check mb-3">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="remember"> Remember me
                    </label>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>';
 echo modal('newUser', 'Crear nuevo usuario', 'test');
?>