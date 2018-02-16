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
        $user = $this->db->sendQuery("SELECT * FROM Users WHERE username=:username AND password=:password",
            ['username' => $userInput['username'], 'password' => $userInput['password']])->fetch();

        return $user['username'] == $userInput['username'] && $user['password'] == $userInput['password'];
    }
}