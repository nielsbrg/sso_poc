<?php

require_once('AuthenticationService.php');

class UsernamePasswordAuthenticationService implements AuthenticationService
{
    private $db;

    public function __construct() {
        $this->db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    public function auth($origin, $userInput) {
        $hashed_pw = password_hash($userInput['password'], PASSWORD_DEFAULT);
        $user = $this->accessUserDetails($this->getSystemByDomain($origin), $userInput['username'], $hashed_pw);

        if(!$user) {
            $this->validateUnknownUser($userInput['username'], $hashed_pw);
        }
    }

    public function accessUserDetails($systemId, $userInput) {
        return $this->db->sendQuery(
            "SELECT * FROM User WHERE system_id=:sys_id AND username=:username AND password=:password",
            ['sys_id' => intval($systemId), 'username' => $userInput['username'], 'password' => $userInput['password']])->fetch();
    }

    private function getSystemByDomain($domain_name) {
        return intval($this->db->sendQuery("SELECT system_id FROM SystemDomain WHERE domain_name LIKE :origin",
            ['origin' => '%' . $domain_name . '%'])->fetch());
    }

    private function validateUnknownUser($userInput) {
        //TODO: Check with origin API to see if input was valid locally.
    }
}