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
        $_POST["symbol"] = strtoupper($_POST["symbol"]);
        $sellshares = query("SELECT shares FROM shares WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        if ($sellshares == NULL)
            apologize("You don't own shares from that company.");
        if ($sellshares[0]["shares"] < $_POST["shares"])
            apologize("You don't have enough shares.");
        $sellshares[0]["shares"] = $sellshares[0]["shares"] - $_POST["shares"];
        if ($sellshares[0]["shares"] > 0)
            query("UPDATE shares SET shares = ? WHERE id = ? AND symbol = ?", $sellshares[0]["shares"], $_SESSION["id"], $_POST["symbol"]);
        else
            query("DELETE FROM shares WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        $stock = lookup($_POST["symbol"]);
        $money = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
        $money[0]['cash'] = ($stock["price"] * $_POST["shares"]) + $money[0]["cash"];
        query("UPDATE users SET cash = ? WHERE id = ?", $money[0]["cash"], $_SESSION["id"]);
        query("INSERT INTO history (id, type, symbol, shares) VALUES (?, ?, ?, ?)", $_SESSION["id"], "Sell", $_POST["symbol"], $_POST["shares"]);
        render("show_sell.php", ["title" => "Transaction Complete!", "shares" => $_POST["shares"], "name" => $stock["name"], "symbol" => $stock["symbol"], "price" => $stock["price"], "balance" => $money[0]["cash"]]);
        
    }
    else
    {
        // else render form
        render("sell_form.php", ["title" => "Sell"]);
    }

?>
