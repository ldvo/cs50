<?php

    // configuration
    require("../includes/config.php");
    require_once("PHPMailer/class.phpmailer.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["oldpass"]) or empty($_POST["newpass"]) or $_POST["newpass"] != $_POST["confirmation"])
            apologize("One or more fields is empty or confirmartion doesn't match new password.");
        else
        {
            $rows = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 
            $row = $rows[0];
            // compare hash of user's input against hash that's in database
            if (crypt($_POST["oldpass"], $row["hash"]) == $row["hash"])
            {
                query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["newpass"]), $_SESSION["id"]);
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
                $mail->Subject = "Password Changed";
                $mail->Body = "<h3> You have changed your password to: <br> {$_POST["newpass"]} </h3>";
                $mail->AddAddress($row["mail"]);
                $mail->Send();
                render("password_success.php", ["title" => "Change Password"]);
            }
            else
                apologize("Old password is incorrect.");            
        }
           
    }
    else
    {
        // else render form
        render("password_form.php", ["title" => "Change Password"]);
    }

?>

<br/> <br/> <h4> <a href="logout.php"> Log out </a> </h4>
