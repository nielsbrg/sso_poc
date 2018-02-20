<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 16-2-2018
 * Time: 15:57
 */

class UserMigrationService implements MigrationService
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUser($system_id, $userInput)
    {
        $potentialMatches = $this->db->sendQuery(
            "SELECT * FROM User WHERE system_id=:sys_id AND username=:user",
            ['sys_id' => intval($system_id), 'user' => $userInput['username']])->fetchAll();

        foreach($potentialMatches as $user) {
            if(password_verify($userInput['password'], $user['password'])) {
                return new User($user['system_id'], $user['user_id'], $user['username'], $user['password']);
            }
        }
        return null;
    }

    public function migrateUser($system_id, $userInput)
    {
        $migrationApiUrl = $this->getMigrationApiById($system_id);
        $apiAuthResponse = $this->authenticateWithMigrationApi($migrationApiUrl);
        if($apiAuthResponse->succeeded) {
            $apiValidateResponse = $this->validateUnknownUser($migrationApiUrl, $userInput, $apiAuthResponse->jwt);
            if ($apiValidateResponse->isValid) {
                $this->saveUserInSSO($system_id, $apiValidateResponse->user_id, $userInput['username'], $userInput['password']);
                return new User($system_id, $apiValidateResponse->user_id, $userInput['username'], $userInput['password']);
            }
        }
        return null;
    }

    private function authenticateWithMigrationApi($apiUrl) {
        $response = Requests::post($apiUrl . '/auth', array(), array('sso_password' => SSO_PASSWORD));
        return json_decode($response->body);
    }

    private function getMigrationApiById($systemId) {
        return $this->db->sendQuery("SELECT api_url FROM SystemMigrationApi WHERE system_id=:system_id",
            ['system_id' => $systemId])->fetch()['api_url'];
    }

    private function validateUnknownUser($apiUrl, $userInput, $authToken) {
        $body = ['username' => $userInput['username'], 'password' => $userInput['password']];
        $response = Requests::post($apiUrl . '/users/validate', array('Authorization' => 'Bearer ' . $authToken), $body);
        return json_decode($response->body);
    }

    private function saveUserInSSO($system_id, $user_id, $username, $password) {
        $this->db->sendQuery(
            'INSERT INTO User(system_id, user_id, username, password) VALUES(:system_id, :user_id, :username, :password)',
            ['system_id' => $system_id, 'user_id' => $user_id, 'username' => $username,
             'password' => password_hash(trim($password), PASSWORD_DEFAULT)]);
    }
}