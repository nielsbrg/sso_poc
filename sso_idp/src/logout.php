<?php

require_once('config/idp_config.php');

require_once('../vendor/rmccue/requests/library/Requests.php');
Requests::register_autoloader();
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
    $sys_name = $systemService->getSystemNameById($systemService->getSystemByDomain($_GET['origin']));
    setcookie('SSO_id', null, -1);
    setcookie('session_id_WMS', null, -1);
    setcookie('session_id_2', null, -1);
    header('Location: http://' . $_GET['origin']);
    die();
}
else {
    header('Location: http://' . $_GET['origin']);
    die();
}