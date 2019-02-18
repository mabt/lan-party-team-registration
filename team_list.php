<?php

require_once('db.php');
$sth = $dbh->query("SELECT reg_name, reg_team,reg_payed FROM registered ORDER BY reg_team");
?>
<table border="1" id="teamlist" align="center">
<h3 align=center>Liste des inscrits</h3>

<tr>
<th><center> Pseudo </center></th>
<th><center> Nom de la team </center></th>
<th><center> Prépayé? </center></th>
</tr>

<?php
foreach($sth as $row)
    {
        echo "</tr>";
        echo "<td><center> $row[reg_name] </center></td>";
        echo "<td><center> $row[reg_team] </center></td>";
        echo "<td><center> $row[reg_payed] </center></td>";
        echo "</tr>";
    }
?>
