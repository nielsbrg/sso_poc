<?php

class UsernamePasswordAuthenticationService implements AuthenticationService
{
    private $db;
    private $userMigrationService;
    private $sessionGenerator;
    private $session;
    private $userInfo;

    public function __construct($db) {
        $this->db = $db;
        $this->userMigrationService = new UserMigrationService($db);
        $this->sessionGenerator = new UserSessionService($db);
    }

    public function auth($origin, $userInput) {
        $system_id = $this->getSystemByDomain($origin);
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

    public function getUserInfo() {
        return $this->userInfo;
    }

    private function onAuthenticatedUser($system_id, $user_id) {
        $this->sessionGenerator->deleteSessionsForUser($system_id, $user_id);
        $this->session = $this->sessionGenerator->createNewSession($system_id, $user_id);
        $this->userInfo = ['system_id' => $system_id, 'user_id' => $user_id];
        $this->sessionGenerator->saveSession($this->session);
    }

    private function getSystemByDomain($domain_name) {
        return intval($this->db->sendQuery("SELECT system_id FROM SystemDomain WHERE domain_name LIKE :origin",
            ['origin' => '%' . $domain_name . '%'])->fetch());
    }
}