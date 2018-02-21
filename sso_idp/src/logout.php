<?php

require_once('requires.php');

$db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$ssoSessionService = new SSOSessionService($db);
$userSessionService = new UserSessionService($db);
$systemService = new SystemService($db);

if(isset($_COOKIE['SSO_token'])) {
    $master_session_id = base64_decode($_COOKIE['SSO_token']);
    $userSessionService->deleteSessionsForUser($master_session_id);
    $ssoSessionService->deleteSession($master_session_id);

    $systems = $systemService->getSystemNames();

    foreach($systems as $system) {
        setcookie('session_id_' . $system['name'], null, -1);
    }
    setcookie('SSO_token', null, -1);
    setcookie('PHPSESSID', null, -1);
    header('Location: http://' . $_GET['origin']);
    die();
}
else if(isset($_GET['origin'])) {
    header('Location: http://' . $_GET['origin']);
    die();
}
else {
    header('Location: http://' . IDP_HOST . ':' . IDP_PORT);
    die();
}