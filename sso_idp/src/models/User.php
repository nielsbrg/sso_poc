<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 11:02
 */

class User
{
    public $system_id;
    public $user_id;
    public $username;
    public $password;

    public function __construct($system_id, $user_id, $username, $password) {
        $this->system_id = $system_id;
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password = $password;
    }
}