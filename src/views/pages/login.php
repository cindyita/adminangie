<div class="w-100 h-100 d-flex justify-content-center align-items-center login font1">

    <div class="text-center box">
        <div class="w-100 d-flex justify-content-center">
            <div class="logo">
                <a href="home">
                    <img src="assets/img/system/logo.png" alt="logo">
                </a>
            </div>
        </div>
        
        <div>
            <h3>Iniciar sesión</h3>
        </div>
        <form method="post" id="login">
            <div class="mt-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mt-3">
                <label for="pass" class="form-label">Password:</label>
                <input type="password" name="pass" class="form-control" id="pass" required>
            </div>
            <!-- <div>
                <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITEKEY'] ?>"></div>
            </div> -->
            <div class="mt-3">
                <button type="submit" class="btn btn-secondary">Login</button>
            </div>
        </form>
    </div>
    
</div>
