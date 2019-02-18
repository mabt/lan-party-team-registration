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

$current_user = wp_get_current_user();
if ( 0 == $current_user->ID ) {
    $result = 0;
    echo $result;
} else {
    require_once('db.php');
    
    $result = 0;
    
    $team_owner = "SELECT COUNT(*) AS num FROM `teams` WHERE team_owner = :team_owner";
    $stmt1 = $dbh->prepare($team_owner);
    $stmt1->bindValue(':team_owner', $current_user->user_login);
    $stmt1->execute();
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
    
    $reg_name = "SELECT COUNT(*) AS num FROM `registered` WHERE reg_name = :reg_name";
    $stmt2 = $dbh->prepare($reg_name);
    $stmt2->bindValue(':reg_name', $current_user->user_login);
    $stmt2->execute();
    $row1 = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    if (($row['num'] > 0) OR ($row1['num'] > 0))
        {
            $result = 1;
            echo $result;
        } else {
        echo $result;
    }
    $dbh = null;
}
?>
