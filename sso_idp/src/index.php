<?php
    require_once('requires.php');

    $db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $sessionManager = new UserSessionService($db);
    $systemService = new SystemService($db);
    $authenticator = new UsernamePasswordAuthenticationService($db, $sessionManager, $systemService);

    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_GET['origin'])) {
        $userInput = array('username' => $_POST['username'], 'password' => $_POST['password']);
        $system_id = $systemService->getSystemByDomain($_GET['origin']);
        $authSucceeded = $authenticator->auth($system_id, $userInput);
        if($authSucceeded) {
            $expiresFormat = 'D, d M Y H:i:s';
            $token = hash_hmac('sha256', SSO_PASSWORD, SSO_PRIVATE_KEY);
            $expires_at = date($expiresFormat, time() + 60*30);
            $SSOCookie = 'SSO_token=' . $token . ';HttpOnly' . ';Expires=' . $expires_at;
            $session_id = $sessionManager->getNewSessionId();
            $sessionCookie = 'session_id_' . $systemService->getSystemNameById($system_id) . '='
                . $session_id . ';HttpOnly' .
                ';Expires=' . $expires_at;
            header('Set-Cookie: ' . $sessionCookie, false);
            header('Set-Cookie: ' . $SSOCookie, false);
            header('Location: ' . 'http://' . $_GET['origin']);
            die();
        }
        else {
            echo 'invalid credentials given';
        }
    }
    else if(isset($_COOKIE['SSO_token']) && isset($_GET['origin'])) {
        if(hash_hmac('sha256', SSO_PASSWORD, SSO_PRIVATE_KEY) == $_COOKIE['SSO_token']) {
            $system_id = $systemService->getSystemByDomain($_GET['origin']);
            $sys_name = $systemService->getSystemNameById($system_id);
            if(!empty($sys_name) && !empty($newSession)) {
                $expires_at_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $newSession['expires_at'])->getTimestamp();
                $sessionCookie = 'session_id_' . $sys_name . '=' . $newSession['session_id'] . ';HttpOnly' .
                    ';Expires=' . date('D, d M Y H:i:s', $expires_at_timestamp);
                header('Set-Cookie: ' . $sessionCookie, false);
                header('Location: ' . 'http://' . $_GET['origin']);
                die();
            }
        }
        else {
            die('There has been tampered with the SSO token!');
        }
    }
    else if(empty($_GET['origin'])) {
        die('ERROR: There was no origin to redirect back to');
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