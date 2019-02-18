<?php
require ('/home/www/sitez.fr/wp-load.php');
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

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    $(function() {
        var url = 'https://sitez.fr/inscription/bepartof_team_ajax.php';
        $.post(url, {})
            .done(function(data) {
                if (data > 0) {
                    $('#teamleave').show();
                } else {
                    $('#createandjoin').show();
                }
            });
    });
</script>

<form>
    <input type="button" style="display:none" value="Je souhaite quitter la team" id="teamleave" />
</form>
<script>
    $(function() {
        $('#teamleave').on('click', function() {
            var url = '../inscription/leave_team_ajax.php';
            $.get(url, {})
                .done(function(data) {
                    if (data > 0) {
                        $('#createandjoin').show();
                        $('#teamleave').hide();
                    } else {}
                });
        });
    });
</script>

<table id="createandjoin" style="display:none">
    <tr>
        <td>
            <h3 align=left>Je crée ma team</h3>
            <form>
                <label>Nom de la team :</label>
                <input type="text" name="tname" id="tname" required="required" placeholder="" readonly onfocus="this.removeAttribute('readonly');" />
                <br/>
                <label>Mot de passe :</label>
                <input type="password" name="pwd" id="pwd" required="required" placeholder="" readonly onfocus="this.removeAttribute('readonly');" />
                <br/>
                <input type="button" id="teamcreate" value="Créer" />
            </form>

            <script>
                $(function() {
                    $('#teamcreate').on('click', function() {
                        var team_name = $('#tname').val();
                        var team_password = $('#pwd').val();
                        if (!team_name || !team_password) {
                            $('.error').show(3000).html("Les deux champs sont obligatoires.").delay(3200).fadeOut(3000);
                        } else {
                            var url = 'https://sitez.fr/inscription/create_team_ajax.php';
                            $.post(url, {
                                    team_name: team_name,
                                    team_password: team_password
                                })
                                .done(function(data) {
                                    if (data > 0) {
                                        $('#createandjoin').hide();
                                        $('#teamleave').show();
                                    } else {}
                                });
                        }
                    });
                });
            </script>
        </td>
        <td>
            <h3 align=left>Je rejoins ma team</h3>
            <?php include '/home/www/sitez.fr/inscription/db.php'; $sql='SELECT * FROM teams' ; $req=$ dbh->query($sql); ?>
            <form>
                <label>Nom de la team : </label>
                <select id="selected_team">
                    <option selected="NO TEAM">NO TEAM</option>
                    <?php foreach($req as $row) : ?>
                    <option value="<?php echo $row['team_name']; ?>">
                        <?php echo $row[ 'team_name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                </br>
                <label>Mot de passe :</label>
                <input type="password" name="input_team_password" id="pwd2" placeholder="" readonly onfocus="this.removeAttribute('readonly');">
                <br/>
                <input type="button" value="Rejoindre" id="jointeam" />
            </form>
            <script>
                $(function() {
                    $('#jointeam').on('click', function() {
                        var selected_team = $("#selected_team option:selected").val();
                        var selected_team_password = $('#pwd2').val();
                        if (!selected_team || !selected_team_password) {} else {
                            var url = 'https://sitez.fr/inscription/join_team_ajax.php';
                            $.post(url, {
                                    selected_team: selected_team,
                                    selected_team_password: selected_team_password
                                })
                                .done(function(data) {
                                    if (data > 0) {
                                        $('#createandjoin').hide();
                                        $('#teamleave').show();
                                        //$('#teamlist tr:last').after('<tr><td><center><?php echo $current_user->user_login; ?></center></td><td><center>('selected_team')</center></td></tr>');
                                    } else {}
                                });
                        }
                    });
                });
            </script>
        </td>
    </tr>
</table>

<div id="teamlist"></div>
<script>
    $(function() {
        var url = 'https://sitez.fr/inscription/teamlist.php';
        $.post(url, {})
            .done(function(data) {
                $('#teamlist').append(data);
            });
    });
</script>
