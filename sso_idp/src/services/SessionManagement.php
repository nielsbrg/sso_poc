<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 12:26
 */

interface SessionManagement
{
    public function getSessionForUser($system_id, $user_id);
    public function createNewSession($system_id, $user_id);
    public function saveSession($session);
    public function deleteSessionsForUser($system_id, $user_id);
}