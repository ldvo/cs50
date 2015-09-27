<?php

    // configuration
    require("../includes/config.php");
    require_once("PHPMailer/class.phpmailer.php");
    require_once("../includes/recaptchalib.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $privatekey = "6LeU4PMSAAAAAM5OTiUw9HJ1nzw8LE4BObX6sFLB";
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        if (!$resp->is_valid)
            apologize("Incorrect captcha.");           
        else if (empty($_POST["username"]) or empty($_POST["password"]) or empty($_POST["mail"]))
            apologize("One or more fields is empty.");
        else if ($_POST["password"] != $_POST["confirmation"])
            apologize("Password doesn't match confirmation.");
        else if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$_POST["mail"])) 
            apologize("Invalid email adress."); 
        else if (query("INSERT INTO users (username, hash, cash, mail) VALUES(?, ?, 1000000.00, ?)", $_POST["username"], crypt($_POST["password"]), $_POST["mail"]) === false)
            apologize("Username already exists.");
        else
        {
            $mail = new PHPMailer(); // create a new object
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "cs50finance2014@gmail.com";
            $mail->Password = "cs50finance123";
            $mail->SetFrom("cs50finance2014@gmail.com", "C$50 Finance");
            $mail->Subject = "New Account";
            $mail->Body = "<h3> User: <br> {$_POST["username"]} <br> Password: <br> {$_POST["password"]} </h3>";
            $mail->AddAddress($_POST["mail"]);
            $mail->Send();
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"];
            $_SESSION["id"] = $id;
            redirect("/");
        }
            
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
