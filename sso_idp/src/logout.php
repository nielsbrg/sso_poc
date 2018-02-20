<?php

require_once('config/idp_config.php');
require_once('services/SessionManagement.php');
require_once('database/DatabaseConnection.php');
require_once('services/UserSessionService.php');
require_once('services/SystemService.php');

$db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$sessionManager = new UserSessionService($db);
$systemService = new SystemService($db);

if(isset($_COOKIE['SSO_id'])) {
    $values = preg_split('/[.]/', $_COOKIE['SSO_id']);
    $sessionManager->deleteSessionsForUser($values[0], $values[1]);
    $systems = $systemService->getSystemNames();

    foreach($systems as $system) {
        setcookie('session_id_' . $system['name'], null, -1);
    }
    setcookie('SSO_id', null, -1);
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