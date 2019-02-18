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

$team_name = trim($_POST["team_name"]);
$team_password = trim($_POST["team_password"]);

$current_user = wp_get_current_user();
if ( 0 == $current_user->ID ) {
    $result = 0;
    echo $result;
} else {   

    require_once('db.php');
    
    $result = 0;

    $result3 = "SELECT COUNT(*) AS num FROM `teams` WHERE team_name = :team_name";
    $stmt3 = $dbh->prepare($result3);
    $stmt3->bindValue(':team_name', $team_name);
    $stmt3->execute();
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    $result4 = "SELECT COUNT(*) AS num FROM `registered` WHERE reg_team = :reg_team";
    $stmt4 = $dbh->prepare($result4);
    $stmt4->bindValue(':reg_team', $team_name);
    $stmt4->execute();
    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

    if(($row3['num'] > 0) OR ($row4['num'] > 0)){
        $result = 0;
        echo $result;
    } else {
        
        $stmt = $dbh->prepare("INSERT INTO teams(team_name, team_password, team_owner) VALUES (:team_name, :team_password, :team_owner)");
        
        $stmt->bindParam(':team_name', $team_name);
        $stmt->bindParam(':team_password', $team_password);
        $stmt->bindParam(':team_owner', $current_user->user_login);
        
        $stmt2 = $dbh->prepare("INSERT INTO registered(reg_name, reg_team) VALUES (:reg_name, :reg_team)");
        $stmt2->bindParam(':reg_name', $current_user->user_login);
        $stmt2->bindParam(':reg_team', $team_name);
        
        if(($stmt2->execute()) && ($stmt->execute())){
            $result =1;
        }
        echo $result;
        $dbh = null;      
    }
}
?>
