<form action="register.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" name="username" placeholder="Username" type="text"/>
        </div>
        <div class="form-group">
            <input autofocus class="form-control" name="mail" placeholder="Mail" type="text"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="password" placeholder="Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="confirmation" placeholder="Confirmation" type="password"/>
        </div>
        <div class="form-group" align=center>
           <?php
             require_once("../includes/recaptchalib.php");
             $publickey = "6LeU4PMSAAAAAOf2hi4JO-bKhBZZlnnhBdWGc6nk"; // you got this from the signup page
             echo recaptcha_get_html($publickey);
            ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Register</button>
        </div>
    </fieldset>
</form>
<div>
    or <a href="login.php">log in</a>
</div>
