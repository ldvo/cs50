<table id=table>
    <tr>
        <td class=tablecell> <b>Date</b> </td>
        <td class=tablecell>   <b>Type</b> </td>
        <td class=tablecell> <b>Symbol</b></td>
        <td class=tablecell> <b>Shares</b> </td>
<?php
    foreach ($positions as $position)
    {
        print("<tr>");
        print("<td class=tablecell>{$position["date"]}</td>");
        print("<td class=tablecell>{$position["type"]}</td>");
        print("<td class=tablecell>{$position["symbol"]}</td>");
        print("<td class=tablecell>{$position["shares"]}</td>");
        print("</tr>");
    }
?>
    
</table>

<br/> <br/> <h4> <a href="logout.php"> Log out </a> </h4>
