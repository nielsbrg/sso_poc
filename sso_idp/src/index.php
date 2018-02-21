<?php
    require_once('requires.php');

    $db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $userSessionService = new UserSessionService($db);
    $ssoSessionService = new SSOSessionService($db);
    $systemService = new SystemService($db);
    $authenticator = new UsernamePasswordAuthenticationService($db, $userSessionService, $systemService);

    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_GET['origin'])) {
        $userInput = array('username' => $_POST['username'], 'password' => $_POST['password']);
        $system_id = $systemService->getSystemByDomain($_GET['origin']);
        $authSucceeded = $authenticator->auth($system_id, $userInput);
        if($authSucceeded) {
            $user = $authenticator->getAuthenticatedUser();

            $SSO_session = $ssoSessionService->createNewSession($ssoSessionService->getNewSessionId(), $user->system_id, $user->user_id);
            $ssoSessionService->saveSession($SSO_session);

            $client_session = $userSessionService->createNewSession($SSO_session->master_session_id, $user->system_id);
            $userSessionService->saveSession($client_session);

            header($ssoSessionService->getCookieString($SSO_session), false);
            header($userSessionService->getCookieString($client_session, $systemService->getSystemNameById($user->system_id)), false);
            header('Location: ' . 'http://' . $_GET['origin']);
            die();
        }
        else {
            echo 'invalid credentials given';
        }
    }
    else if(isset($_COOKIE['SSO_token']) && isset($_GET['origin'])) {
        $SSO_session = $ssoSessionService->getSessionForUser(base64_decode($_COOKIE['SSO_token']));
        if(!empty($SSO_session)) {
            $client_system_id = $systemService->getSystemByDomain($_GET['origin']);
            $client_session = $userSessionService->createNewSession($SSO_session->master_session_id, $client_system_id);
            $userSessionService->saveSession($client_session);
            echo $userSessionService->getCookieString($client_session, $systemService->getSystemNameById($client_system_id));
            header($userSessionService->getCookieString($client_session, $systemService->getSystemNameById($client_system_id)), false);
            header('Location: ' . 'http://' . $_GET['origin']);
            die();
        }
    }
    else if(empty($_GET['origin'])) {
        die('ERROR: There was no origin to redirect back to');
    }
    else {

    }
?>
<html>
    <body>
        <h1>Identity provider</h1>
        <form method="POST">
            <div>
                <label for="username">Gebruikersnaam</label>
                <input name="username" type="text"/>
            </div>
            <br>
            <div>
                <label style="margin-right: 25px" for="password">Wachtwoord</label>
                <input name="password" type="text"/>
            </div>
            <div>
                <input type="submit"/>
            </div>
        </form>
    </body>
</html>