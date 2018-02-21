<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 21-2-2018
 * Time: 09:52
 */

class SSOSession
{
    public $master_session_id;
    public $system_id;
    public $user_id;

    public function __construct($master_session_id, $system_id, $user_id)
    {
        $this->master_session_id = $master_session_id;
        $this->system_id = $system_id;
        $this->user_id = $user_id;
    }
}