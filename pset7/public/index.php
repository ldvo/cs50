<?php

    // configuration
    require("../includes/config.php"); 
    $cash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    $rows = query("SELECT * FROM shares WHERE id = ?", $_SESSION["id"]);
    if (empty($rows))
        render("portfolioempty.php", ["money" => $cash, "title" => "Portfolio"]);
    else
    {
        $positions = [];
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                    "name" => $stock["name"],
                    "price" => $stock["price"],
                    "shares" => $row["shares"],
                    "symbol" => $stock["symbol"],
                    "change" => $stock["change"],
                    "perchange" => $stock["perchange"],
                ];
            }
        }
        render("portfolio.php", ["positions" => $positions, "title" => "Portfolio", "money" => $cash]);
    }


?>
