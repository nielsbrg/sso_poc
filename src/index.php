<?php
    require_once('config/idp_config.php');
    require_once('database/DatabaseConnection.php');
    require_once('services/UsernamePasswordAuthenticationService.php');

    $authenticator = new UsernamePasswordAuthenticationService();

    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_GET['origin'])) {
        $userInput = array('username' => $_POST['username'], 'password' => $_POST['password']);
        $authenticator->auth($_GET['origin'], $userInput);
    }
?>

<html>
    <head>

    </head>
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