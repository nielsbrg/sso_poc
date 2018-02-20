<?php
    require_once('requires.php');

    $db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $sessionManager = new UserSessionService($db);
    $systemService = new SystemService($db);
    $authenticator = new UsernamePasswordAuthenticationService($db, $sessionManager, $systemService);

    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_GET['origin'])) {
        $userInput = array('username' => $_POST['username'], 'password' => $_POST['password']);
        $authSucceeded = $authenticator->auth($_GET['origin'], $userInput);
        if($authSucceeded) {
            $session = $authenticator->getSession();
            $sys_name = $systemService->getSystemNameById($session->system_id);
            $SSOCookie = 'SSO_id=' . $session->system_id . '.' . $session->user_id . '';
            $sessionCookie = 'session_id_' . $sys_name . '=' . $session->session_id . ';HttpOnly' .
                ';Expires=' . date('D, d M Y H:i:s', $session->expires_at_timestamp);
            header('Set-Cookie: ' . $sessionCookie, false);
            header('Set-Cookie: ' . $SSOCookie, false);
            header('Location: ' . 'http://' . $_GET['origin']);
            die();
        }
        else {
            echo 'invalid credentials given';
        }
    }
    else if(isset($_COOKIE['SSO_id'])) {
        $values = preg_split('/[.]/', $_COOKIE['SSO_id']);
        $session = $sessionManager->getSessionForUser($values[0], $values[1]);
        $sys_name = $systemService->getSystemNameById($systemService->getSystemByDomain($_GET['origin']));
        $expires_at_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $session['expires_at'])->getTimestamp();
        $sessionCookie = 'session_id_' . $sys_name . '=' . $session['session_id'] . ';HttpOnly' .
            ';Expires=' . date('D, d M Y H:i:s', $expires_at_timestamp);
        header('Set-Cookie: ' . $sessionCookie, false);
        header('Location: ' . 'http://' . $_GET['origin']);
        die();
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