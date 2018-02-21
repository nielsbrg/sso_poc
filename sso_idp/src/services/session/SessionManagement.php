<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 12:26
 */

interface SessionManagement
{
    /** Retrieves a session
     * @param $session_id string - user id that the user has in the local system
     * @return Session object from the db
     */
    public function getSessionForUser($session_id);

    /** Saves a session to the database.
     * @param $session
     * @return mixed
     */
    public function saveSession($session);
}