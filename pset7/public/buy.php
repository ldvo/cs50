<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]) or empty($_POST["shares"]))
        {
            apologize("One or more fields is empty.");
        }
        if (!preg_match("/^\d+$/", $_POST["shares"]))
            apologize("You can only buy whole shares of stocks.");
        $oldcash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
        if ($oldcash === NULL)
            apologize("You don't have enough cash.");
        $stock = lookup($_POST["symbol"]);
        if ($stock == false)
            apologize("Invalid symbol.");
        $stock["price"] = $stock["price"] * $_POST["shares"];
        if ($oldcash[0]['cash'] < $stock["price"])
            apologize("You don't have enough cash.");
        $_POST["symbol"] = strtoupper($_POST["symbol"]);
        query("INSERT INTO shares (id, symbol, shares) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES (shares)", $_SESSION["id"], $_POST["symbol"], $_POST["shares"]);
        $oldcash[0]["cash"] = $oldcash[0]["cash"] - $stock["price"];
        query("UPDATE users SET cash = ? WHERE id = ?", $oldcash[0]["cash"], $_SESSION["id"]);
        query("INSERT INTO history (id, type, symbol, shares) VALUES (?, ?, ?, ?)", $_SESSION["id"], "Buy", $_POST["symbol"], $_POST["shares"]);
        render("show_buy.php", ["title" => "Transaction Complete!", "shares" => $_POST["shares"], "name" => $stock["name"], "symbol" => $stock["symbol"], "price" => $stock["price"], "balance" => $oldcash[0]["cash"]]);
        
    }
    else
    {
        // else render form
        render("buy_form.php", ["title" => "Sell"]);
    }

?>
