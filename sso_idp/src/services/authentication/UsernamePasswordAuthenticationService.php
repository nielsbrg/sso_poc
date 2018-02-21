<?php

class UsernamePasswordAuthenticationService implements AuthenticationService
{
    private $db;
    private $userMigrationService;
    private $sessionService;
    private $systemService;
    private $user;

    public function __construct($db, $sessionService, $systemService) {
        $this->db = $db;
        $this->userMigrationService = new UserMigrationService($db);
        $this->sessionService = $sessionService;
        $this->systemService = $systemService;
    }

    public function auth($system_id, $userInput) {
        $user = $this->userMigrationService->getUser($system_id, $userInput);
        if($user) {
            $this->user = $user;
            return true;
        }
        else {
            $migrationResult = $this->userMigrationService->migrateUser($system_id, $userInput);
            if($migrationResult) {
                $this->user = $migrationResult;
                return true;
            }
        }
        return false;
    }

    public function getAuthenticatedUser() {
        return $this->user;
    }
}