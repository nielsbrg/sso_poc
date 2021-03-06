<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 21-2-2018
 * Time: 09:45
 */

class BaseSessionService
{
    protected $expiresFormat;

    public function __construct($expiresFormat) {
        $this->expiresFormat = $expiresFormat;
    }

    public function getNewSessionId() {
        session_start();
        $id = session_id();
        $_SESSION = array();
        setcookie('PHPSESSID', null, -1);
        session_destroy();
        return $id;
    }
}