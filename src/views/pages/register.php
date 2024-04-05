<div>
    <div>
        <h3>Register</h3>
    </div>
    <form method="post" id="register">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass" required>
        </div>
        <div>
            <label for="cpass">Confirm password:</label>
            <input type="password" id="cpass" required>
        </div>
        <!-- <div>
            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITEKEY'] ?>"></div>
        </div> -->
        <div>
            <button type="submit">Send</button>
        </div>
    </form>
</div>
