<?php
require_once('config/sp_config.php');

if(isset($_COOKIE['access_token'])) {
    echo 'logged in';
}
else {
    //TODO: redirect sso
    header('Location: ' . $IDP_HOST.':'.$IDP_PORT . '?next=' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    die();
}
?>

<html>
    <head>

    </head>
    <body>
        <h1>Service provider 2</h1>
    </body>
</html>