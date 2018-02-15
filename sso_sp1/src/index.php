<?php
    require_once('config/sp_config.php');

    if(isset($_COOKIE['access_token'])) {
        echo 'logged in';
    }
    else {
        $target = IDP_HOST . ':' . IDP_PORT;
        $origin = '?origin=' . $_SERVER['HTTP_HOST'];
        $resource = '&resource='. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: '.$target.$origin.$resource);
        die();
    }
?>

<html>
    <head>

    </head>
    <body>
        <h1>Service provider 1</h1>
    </body>
</html>