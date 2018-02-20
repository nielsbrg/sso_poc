<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 16-2-2018
 * Time: 15:11
 */

require_once('ValidationService.php');

class UserValidationService implements ValidationService
{
    private $db;

    public function __construct() {
        $this->db = new DatabaseConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    public function validate($userInput) {
        $users = $this->db->sendQuery("SELECT * FROM User WHERE username=:username",
            ['username' => $userInput['username']])->fetchAll();

        return $this->validateListOfUsers($users, $userInput['password']);
    }

    public function validateListOfUsers($users, $inputPassword) {
        foreach($users as $user) {
            if(password_verify($inputPassword, $user['password'])) {
                return [
                    'user_id' => intval($user['id']),
                    'isValid' => true
                ];
            }
        }
        return [
            'isValid' => false
        ];
    }
}