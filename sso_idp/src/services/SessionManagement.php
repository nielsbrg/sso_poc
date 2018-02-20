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
     * @param $system_id The system the user has logged into
     * @param $user_id  The user id that the user has in the local system
     * @return Session object from the db
     */
    public function getSessionForUser($system_id, $user_id);

    /** Generates a new session id
     * @param $system_id
     * @param $user_id
     * @return mixed
     */
    public function createNewSession($system_id, $user_id);

    /** Saves a session model to the database
     * @param $session UserSession
     * @return nothing
     */
    public function saveSession($session);

    /** Deletes all sessions for the user with the given ids.
     * @param $system_id
     * @param $user_id
     * @return nothing
     */
    public function deleteSessionsForUser($system_id, $user_id);
}