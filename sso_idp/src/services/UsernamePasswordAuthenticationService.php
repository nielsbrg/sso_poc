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
        $system_id = $this->getSystemByDomain($origin);
        $user = $this->accessUserDetails($system_id, $userInput['username'], $hashed_pw);

        if(!$user) {
            $migrationApiUrl = $this->getMigrationApiById($system_id);
            $apiAuthResponse = $this->authenticateWithMigrationApi($migrationApiUrl);
            if($apiAuthResponse->succeeded) {
                $apiValidateResponse = $this->validateUnknownUser($migrationApiUrl, $userInput, $apiAuthResponse->jwt);
                if($apiValidateResponse['isValidUser']) {

                }
            }
        }
    }

    private function accessUserDetails($systemId, $username, $password) {
        return $this->db->sendQuery(
            "SELECT * FROM User WHERE system_id=:sys_id AND username=:user AND password=:pass",
            ['sys_id' => intval($systemId), 'user' => $username, 'pass' => $password])->fetch();
    }

    private function getSystemByDomain($domain_name) {
        return intval($this->db->sendQuery("SELECT system_id FROM SystemDomain WHERE domain_name LIKE :origin",
            ['origin' => '%' . $domain_name . '%'])->fetch());
    }

    private function getMigrationApiById($systemId) {
        return $this->db->sendQuery("SELECT api_url FROM SystemMigrationApi WHERE system_id=:system_id",
            ['system_id' => $systemId])->fetch()['api_url'];
    }

    private function authenticateWithMigrationApi($apiUrl) {
        $response = Requests::post($apiUrl . '/auth', array(), array('sso_password' => SSO_PASSWORD));
        return json_decode($response->body);
    }

    private function validateUnknownUser($apiUrl, $userInput, $authToken) {
        //TODO: Check with origin API to see if input was valid locally.
        $body = ['username' => $userInput['username'], 'password' => $userInput['password']];
        $response = Requests::post($apiUrl . '/users/validate', array('Authorization' => 'Bearer ' . $authToken), $body);
        return json_decode($response->body);
    }
}