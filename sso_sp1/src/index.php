<?php
    require_once('config/sp_config.php');

    $target = IDP_HOST . ':' . IDP_PORT;
    $origin = '?origin=' . $_SERVER['HTTP_HOST'];
    $resource = '&resource='. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if(!isset($_COOKIE['session_id'])) {
        header('Location:' .$target.$origin.$resource);
        die();
    }
    else {
        //TODO: validate session
        echo 'logged in!';
    }
?>
<html>
    <head></head>
    <body>
        <h1>Service provider 1</h1>
    </body>
</html>