<?php
require_once('config/idp_config.php');

require_once('../vendor/rmccue/requests/library/Requests.php');
Requests::register_autoloader();

require_once('database/DatabaseConnection.php');

require_once('models/User.php');
require_once('models/UserSession.php');
require_once('models/SSOSession.php');

require_once('services/authentication/AuthenticationService.php');
require_once('services/migration/MigrationService.php');
require_once('services/session/SessionManagement.php');

require_once('services/migration/UserMigrationService.php');
require_once('services/system/SystemService.php');
require_once('services/session/BaseSessionService.php');
require_once('services/session/SSOSessionService.php');
require_once('services/session/UserSessionService.php');
require_once('services/authentication/UsernamePasswordAuthenticationService.php');
