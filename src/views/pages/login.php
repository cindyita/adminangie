<div>
    <div>
        <h3>Login</h3>
    </div>
    <form method="post" id="login">
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass" required>
        </div>
        <!-- <div>
            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITEKEY'] ?>"></div>
        </div> -->
        <div>
            <button type="submit" class="button is-primary">Send</button>
        </div>
    </form>
</div>
