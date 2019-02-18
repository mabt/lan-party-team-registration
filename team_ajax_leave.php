<?php
require ('wp-load.php');
if (is_user_logged_in())
    {
        global $current_user;
        get_currentuserinfo();
    }
else
    {
        echo '<a href="' . get_bloginfo('url') . '/wp-admin" class="loginlinktop">Login</a>';
    }
?>

<?php

require_once('db.php');

//$result = 0;

$reg_name = "DELETE FROM `registered` WHERE `reg_name` = :reg_name";
$stmt1 = $dbh->prepare($reg_name);
$stmt1->bindValue(':reg_name', $current_user->user_login);
$stmt1->execute();
    
$team_owner = "DELETE FROM `teams` WHERE `team_owner` = :team_owner";
$stmt2 = $dbh->prepare($team_owner);
$stmt2->bindValue(':team_owner', $current_user->user_login);
$stmt2->execute();

// Ajouter une condition propre plus tard
$result = 1;
echo $result;
$dbh = null;

?>
