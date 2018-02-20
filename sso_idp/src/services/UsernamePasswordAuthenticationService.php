<?php

class UsernamePasswordAuthenticationService implements AuthenticationService
{
    private $db;
    private $userMigrationService;
    private $sessionService;
    private $systemService;

    public function __construct($db, $sessionService, $systemService) {
        $this->db = $db;
        $this->userMigrationService = new UserMigrationService($db);
        $this->sessionService = $sessionService;
        $this->systemService = $systemService;
    }

    public function auth($system_id, $userInput) {
        $user = $this->userMigrationService->getUser($system_id, $userInput);
        if($user) {
            return true;
        }
        else {
            $migrationResult = $this->userMigrationService->migrateUser($system_id, $userInput);
            if($migrationResult) {
                return true;
            }
        }
        return false;
    }
}