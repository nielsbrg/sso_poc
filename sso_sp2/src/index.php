<?php
    require_once('config/sp_config.php');

    $target = IDP_HOST . ':' . IDP_PORT;
    $origin = '?origin=' . $_SERVER['HTTP_HOST'];
    $resource = '&resource='. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $loggedIn = false;

    if(isset($_POST['logoutButton'])) {
        $idp_url = $target.'/logout.php';
        header('Location: ' . $idp_url . $origin);
        die();
    }

    if(isset($_COOKIE['session_id_Klantportaal'])) {
        $loggedIn = true;
    }

    if(isset($_POST['loginButton'])) {
        header('Location: ' . $target . $origin . $resource);
        die();
    }
?>
<html>
    <head></head>
    <body>
        <h1>Service provider 1</h1>

        <?php
            echo '<form method="POST">';
            if($loggedIn) {
                echo '<button name="logoutButton" type="submit" value="logout">Sign out</button>';
            } else {
                echo '<button name="loginButton" type="submit" value="login">Sign in</button>';
            }
            echo '</form>';
        ?>
    </body>
</html>