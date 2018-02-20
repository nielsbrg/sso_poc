<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 12:26
 */

interface SessionService
{
    public function createNewSession($system_id, $user_id);
    public function saveSession($session);
}