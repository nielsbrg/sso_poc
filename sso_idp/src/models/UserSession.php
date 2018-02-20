<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 12:24
 */

class UserSession
{
    public $system_id;
    public $user_id;
    public $session_id;
    public $expires_at;
    public $expires_at_timestamp;
    public $created_at;

    public function __construct($system_id, $user_id, $session_id, $expires_at, $expires_at_timestamp, $created_at)
    {
        $this->system_id = $system_id;
        $this->user_id = $user_id;
        $this->session_id = $session_id;
        $this->expires_at = $expires_at;
        $this->expires_at_timestamp = $expires_at_timestamp;
        $this->created_at = $created_at;
    }
}