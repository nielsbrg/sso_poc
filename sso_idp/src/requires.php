<?php
require_once('config/idp_config.php');

require_once('../vendor/rmccue/requests/library/Requests.php');
Requests::register_autoloader();

require_once('database/DatabaseConnection.php');

require_once('models/User.php');
require_once('models/UserSession.php');

require_once('services/AuthenticationService.php');
require_once('services/MigrationService.php');
require_once('services/SessionManagement.php');

require_once('services/UserMigrationService.php');
require_once('services/SystemService.php');
require_once('services/UserSessionService.php');
require_once('services/UsernamePasswordAuthenticationService.php');
