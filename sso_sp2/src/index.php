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
        <h1>Service provider 2</h1>

        <?php
        if($loggedIn) {
            echo '
            <form method="POST">
                <button name="logoutButton" type="submit" value="logout">Log out</button>
            </form>
            ';
        }
        else {
            echo '
            <form method="POST">
                <button name="loginButton" type="submit" value="login">Log in</button>
            ';
        }
        ?>
    </body>
</html>