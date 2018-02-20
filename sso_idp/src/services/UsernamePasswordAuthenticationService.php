<?php

class UsernamePasswordAuthenticationService implements AuthenticationService
{
    private $db;
    private $userMigrationService;
    private $sessionService;
    private $session;
    private $systemService;

    public function __construct($db, $sessionService, $systemService) {
        $this->db = $db;
        $this->userMigrationService = new UserMigrationService($db);
        $this->sessionService = $sessionService;
        $this->systemService = $systemService;
    }

    public function auth($origin, $userInput) {
        $system_id = $this->systemService->getSystemByDomain($origin);
        $user = $this->userMigrationService->getUser($system_id, $userInput);
        if($user) {
            $this->onAuthenticatedUser($system_id, $user->user_id);
            return true;
        }
        else {
            $migrationResult = $this->userMigrationService->migrateUser($system_id, $userInput);
            if($migrationResult) {
                $this->onAuthenticatedUser($system_id, $migrationResult->user_id);
                return true;
            }
        }
        return false;
    }

    public function getSession() {
        return $this->session;
    }

    private function onAuthenticatedUser($system_id, $user_id) {
        $this->sessionService->deleteSessionsForUser($system_id, $user_id);
        $this->session = $this->sessionService->createNewSession($system_id, $user_id);
        $this->sessionService->saveSession($this->session);
    }

}