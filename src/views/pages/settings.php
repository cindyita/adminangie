<div class="d-flex justify-content-between align-items-center">
  <h3>Ajustes</h3>
</div>

<div>
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <h5>Apariencia de la aplicación <i class="fa-solid fa-palette"></i></h5>
        <button class="btn btn-primary" id="saveSettings">Guardar</button>
    </div>
    <hr>
    <div>
        <form method="post" id="saveSettingsForm">
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Nombre de la aplicación:</label>
                <div class="d-flex">
                    <input type="text" class="form-control" name="app_title" value="<?php echo $_SESSION['MYSESSION']['company']['app_title']; ?>">
                </div>
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Nombre de la empresa:</label>
                <div class="d-flex">
                    <input type="text" class="form-control" name="company" value="<?php echo $_SESSION['MYSESSION']['company']['company']; ?>">
                </div>
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Clave de registro:</label>
                <div class="d-flex">
                    <input type="password" class="form-control" name="register_password" placeholder="[Información oculta]">
                </div>
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Color primario:</label>
                <input type="color" class="form-control form-control-color" name="primary_color" value="<?php echo $_SESSION['MYSESSION']['company']['primary_color'] ?? "#213F75"; ?>">
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Color secundario:</label>
                <input type="color" class="form-control form-control-color" name="secondary_color" value="<?php echo $_SESSION['MYSESSION']['company']['secondary_color'] ?? "#A368ED"; ?>">
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Color terciario:</label>
                <input type="color" class="form-control form-control-color" name="tertiary_color" value="<?php echo $_SESSION['MYSESSION']['company']['tertiary_color'] ?? "#F773CC"; ?>">
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Color del texto del menú:</label>
                <input type="color" class="form-control form-control-color" name="menutext_color" value="<?php echo $_SESSION['MYSESSION']['company']['menutext_color'] ?? "#FFFFFF"; ?>">
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Color de acento:</label>
                <input type="color" class="form-control form-control-color" name="accent_color" value="<?php echo $_SESSION['MYSESSION']['company']['accent_color'] ?? "#74d7ff"; ?>">
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Aumentar el texto en:</label>
                <div class="input-group" style="width:fit-content">
                    <span class="input-group-text">+</span>
                    <input type="number" class="form-control form-control-color" name="text_size_plus" value="<?php echo $_SESSION['MYSESSION']['company']['text_size_plus'] ?? 0; ?>">
                    <span class="input-group-text">pt</span>
                </div>
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Logo:</label>
                <div class="d-flex flex-column gap-1">
                    <span class="text-secondary">Actual: <?php echo $_SESSION['MYSESSION']['company']['img_logo'] ?? "logo.png"; ?></span>
                    <div class="d-flex gap-2">
                        <input type="file" name="img_logo" id="img_logo" class="form-control">
                        <img src="<?php echo $_SESSION['MYSESSION'] ? './assets/img/company/'.$_SESSION['MYSESSION']['company']['id'].'/'.$_SESSION['MYSESSION']['company']['img_logo'] : "./assets/img/system/logo.png"; ?>" width="50px">
                    </div>
                </div>
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Favicon:</label>
                <div class="d-flex flex-column gap-1">
                    <span class="text-secondary">Actual: <?php echo $_SESSION['MYSESSION']['company']['img_favicon'] ?? "favicon.png"; ?></span>
                    <div class="d-flex gap-2">
                        <input type="file" name="img_favicon" id="img_favicon" class="form-control">
                        <img src="<?php echo $_SESSION['MYSESSION']['company']['img_favicon'] ? './assets/img/company/'.$_SESSION['MYSESSION']['company']['id'].'/'.$_SESSION['MYSESSION']['company']['img_favicon'] : "./assets/img/system/favicon.png"; ?>" width="50px">
                    </div>
                </div>
            </div>
            <div class="mt-3 d-flex gap-3 align-items-center">
                <label class="form-label">Fondo del login/registro:</label>
                <div class="d-flex flex-column gap-1">
                    <span class="text-secondary">Actual: <?php echo $_SESSION['MYSESSION']['company']['img_font'] ?? "font.jpg"; ?></span>
                    <div class="d-flex gap-2">
                        <input type="file" name="img_font" id="img_font" class="form-control">
                        <img src="<?php echo $_SESSION['MYSESSION']['company']['img_font'] ? './assets/img/company/'.$_SESSION['MYSESSION']['company']['id'].'/'.$_SESSION['MYSESSION']['company']['img_font'] : "./assets/img/system/font.jpg"; ?>" width="50px">
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</div>
<br><br><br>

<div class="mb-5">
    <div class="mt-4">
        <h5>Base de datos <i class="fa-solid fa-triangle-exclamation text-danger"></i></h5>
    </div>
    <hr>

    <div>

        <div class="mt-3" >
            <div class="form-check form-switch">
                <input class="form-check-input cursor-pointer" type="checkbox" id="db_type" name="db_type" <?php echo $_SESSION['MYSESSION']['company']['db_type'] == 1 ? 'checked': "" ?> data-bs-toggle="tooltip" title="Decide si quieres usar la base de datos local o remota (Esta opción no sincroniza los datos)." disabled>
                <label class="form-check-label" for="db_type">Usar base de datos remota</label>
            </div>
        </div>
        <!---------SINCRONIZACIÓN DE BASE DE DATOS----------->
        <div class="d-none">
            <div class="mt-3">
                <button class="btn btn-primary" data-bs-toggle="tooltip" title="Ve los cambios que se han realizado recientemente en la base de datos seleccionada, estos son los cambios que se sincronizarán en caso de escoger una opción de sincronización."><i class="fa-solid fa-database"></i> Ver cambios actuales</button>
            </div>

            <br>

            <div class="mt-3" >
                <button class="btn btn-danger" data-bs-toggle="tooltip" title="Esta opción subirá los cambios que has hecho localmente a la base de datos remota."><i class="fa-solid fa-arrows-rotate"></i> Sincronizar Local > Remoto</button>
            </div>
            <div class="mt-3">
                <button class="btn btn-danger" data-bs-toggle="tooltip" title="Esta opción traera los cambios hechos de la base de datos remota a la base de datos local."><i class="fa-solid fa-arrows-rotate"></i> Sincronizar Remoto > Local</button>
            </div>
            <div class="mt-3">
                <button class="btn btn-danger" data-bs-toggle="tooltip" title="Esta opción borrará todos tus datos locales y traerá los datos remotos."><i class="fa-solid fa-cloud-arrow-down"></i> Igualar Remoto > Local</button>
            </div>
        </div>
        <!----------------------------->
    </div>

</div>

<br><br><br><br>