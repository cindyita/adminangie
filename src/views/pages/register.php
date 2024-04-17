<div class="w-100 h-100 d-flex justify-content-center align-items-center login font1">

    <div class="text-center box">
        <div class="w-100 d-flex justify-content-center">
            <div class="logo">
                <a href="home">
                    <img src="<?php echo $_SESSION['MYSESSION'] ? './assets/img/company/'.$_SESSION['MYSESSION']['company']['id'].'/'.$_SESSION['MYSESSION']['company']['img_logo'] : "./assets/img/system/logo.png"; ?>" alt="logo">
                </a>
            </div>
        </div>
        
        <div>
            <h3>Registro</h3>
        </div>
        <form method="post" id="login">
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
                <label for="registerKey" class="form-label">Clave de registro:</label>
                <input type="number" id="registerKey" name="registerKey" class="form-control" required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-secondary">Registrarse</button>
            </div>
        </form>
    </div>
    
</div>
