<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 12:24
 */

class UserSession
{
    public $master_session_id;
    public $system_id;
    public $session_id;
    public $expires_at;
    public $expires_at_timestamp;
    public $created_at;

    public function __construct($master_session_id, $system_id, $session_id, $expires_at, $expires_at_timestamp, $created_at)
    {
        $this->master_session_id = $master_session_id;
        $this->system_id = $system_id;
        $this->session_id = $session_id;
        $this->expires_at = $expires_at;
        $this->expires_at_timestamp = $expires_at_timestamp;
        $this->created_at = $created_at;
    }
}