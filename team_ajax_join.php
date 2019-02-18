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

    $selected_team = trim($_POST["selected_team"]);
    $selected_team_password = trim($_POST["selected_team_password"]);
    
    $result1 = "SELECT COUNT(*) AS num FROM `teams` WHERE team_name = :team_name AND team_password = :team_password";
    $stmt = $dbh->prepare($result1);
    $stmt->bindValue(':team_name', $selected_team);
    $stmt->bindValue(':team_password', $selected_team_password);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $result2 = "SELECT COUNT(*) AS num FROM `registered` WHERE reg_name = :reg_name";
    $stmt2 = $dbh->prepare($result2);
    $stmt2->bindValue(':reg_name', $current_user->user_login);
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    if(($row['num'] > 0) || ($selected_team == "NO TEAM")){
        if($row2['num'] > 0){
            echo "Vous avez déjà rejoint une team.";
        } else {
            $result = 0;
            
            $stmt3 = $dbh->prepare("INSERT INTO registered(reg_name, reg_team) VALUES (:reg_name, :reg_team)");
            $stmt3->bindParam(':reg_name', $current_user->user_login);
            $stmt3->bindParam(':reg_team', $selected_team);
            
            if ($stmt3->execute()){
                $result =1;
            }
            echo $result;
            $dbh = null;

        }
    } else {
        $result = 0;
        echo $result;
    }
}       
?>
