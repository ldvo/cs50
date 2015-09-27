<table id=table>
    <tr>
        <td class=tablecell> <b>Company</b> </td>
        <td class=tablecell> <b>Symbol</b> </td>
        <td class=tablecell> <b>Shares</b></td>
        <td class=tablecell> <b>Current Price per Share</b> </td>
        <td class=tablecell> <b>Change</b> </td>
        <td class=tablecell> <b>Change (Percent)</b> </td>
        <td class=tablecell> <b>Total</b> </td> </tr>
    <?php
        $total = 0;
        foreach ($positions as $position)
        {
            $totalcash = sprintf('%0.2f', $position["price"] * $position["shares"]);
            $price2 = sprintf('%0.2f', $position["price"]);
            print("<tr>");
            print("<td class=tablecell>{$position["name"]}</td>");
            print("<td class=tablecell>{$position["symbol"]}</td>");
            print("<td class=tablecell>{$position["shares"]}</td>");
            print("<td class=tablecell>$ {$price2}</td>");
            print("<td class=tablecell>{$position["change"]}</td>");
            print("<td class=tablecell>{$position["perchange"]}</td>");
            print("<td class=tablecell>$ {$totalcash}</td>");
            print("</tr>");
            $total = sprintf('%0.2f', $total + $totalcash);
        }
        print("<tr> <td class=tablecell colspan=6> Total in Shares </td> <td class=tablecell>$ {$total} </td> </tr>");
        $cash = sprintf('%0.2f', (string)$money[0]['cash']);
        print("<tr> <td class=tablecell colspan=6> Total in Cash </td> <td class=tablecell>$ {$cash} </td> </tr>");
        $totalmoney = sprintf('%0.2f', $cash + $total);
        print("<tr> <td class=tablecell colspan=6> <b>Total (Shares + Cash)</b> </td> <td class=tablecell><b>$ {$totalmoney} </b></td> </tr>");
        
        

    ?>
    
</table>

<br/> <br/> <h4> <a href="logout.php"> Log out </a> </h4>
