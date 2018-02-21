<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 12:26
 */

interface SessionManagement
{
    /** Retrieves an active session for a user
     * @param $session_id The user id that the user has in the local system
     * @return Session object from the db
     */
    public function getSessionForUser($session_id);

    /** Generates a new session id
     * @param $session
     * @return mixed
     */
    public function saveSession($session);
}