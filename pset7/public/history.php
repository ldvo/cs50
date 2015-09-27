<?php

    // configuration
    require("../includes/config.php"); 
    $rows = query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
    if (empty($rows))
        render("historyempty.php", ["title" => "History"]);
    else
    {
        $positions = [];
        foreach ($rows as $row)
        {
            $positions[] = [
                "date" => $row["date"],
                "type" => $row["type"],
                "symbol" => $row["symbol"],
                "shares" => $row["shares"]
                ];
        }
        render("historylist.php", ["positions" => $positions, "title" => "Portfolio"]);
    }


?>
