<?php
        require("../includes/config.php");
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $stock = lookup($_POST["symbol"]);
            if ($stock === false)
                apologize("Invalid symbol.");
            else 
                $price2 = sprintf('%0.2f', $stock["price"]);
                render("show_quote.php", ["name"=> $stock["name"], "symbol"=> $stock["symbol"], "price"=> $price2]);  
        }
        else
            render("quote_form.php", ["title" => "Quote"]);
?>
    
