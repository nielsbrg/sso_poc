<?php
    require_once('config/idp_config.php');

    require_once('../vendor/rmccue/requests/library/Requests.php');
    Requests::register_autoloader();

    require_once('database/DatabaseConnection.php');

    require_once('models/User.php');
    require_once('models/UserSession.php');

    require_once('services/AuthenticationService.php');
    require_once('services/MigrationService.php');
    require_once('services/TokenService.php');
    require_once('services/SessionGeneration.php');

    require_once('services/UserMigrationService.php');
    require_once('services/UserSessionService.php');
    require_once('services/UsernamePasswordAuthenticationService.php');
    require_once('services/SessionProvider.php');

    $db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $authenticator = new UsernamePasswordAuthenticationService($db);
    $sessionProvider = new SessionProvider($db);

    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_GET['origin'])) {
        $userInput = array('username' => $_POST['username'], 'password' => $_POST['password']);
        $authSucceeded = $authenticator->auth($origin, $userInput);
        if($authSucceeded) {
            $session = $authenticator->getSession();
            $SSOCookie = 'SSO_id=' . $session->system_id . '.' . $session->user_id . '';
            $sessionCookie = 'session_id=' . $session->session_id . ';HttpOnly' .
                ';Expires=' . date('D, d M Y H:i:s', $session->expires_at_timestamp);
            header('Set-Cookie: ' . $sessionCookie, false);
            header('Set-Cookie: ' . $SSOCookie, false);
            header('Location: ' . 'http://' . $_GET['origin']);
            die();
        }
    }
    else if(isset($_COOKIE['SSO_id'])) {
        $values = preg_split('/[.]/', $_COOKIE['SSO_id']);
        $session = $sessionProvider->getSessionForUser($values[0], $values[1]);
        $expires_at_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $session['expires_at'])->getTimestamp();
        $sessionCookie = 'session_id_2=' . $session['session_id'] . ';HttpOnly' .
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
            <div>
                <label for="password">Wachtwoord</label>
                <input name="password" type="text"/>
            </div>
            <div>
                <input type="submit"/>
            </div>
        </form>
    </body>
</html>