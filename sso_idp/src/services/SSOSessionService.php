<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 21-2-2018
 * Time: 09:40
 */

class SSOSessionService extends BaseSessionService implements SessionManagement
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /** Retrieves an active session for a user
     * @param $session_id int - master session id for the user
     * @return SSOSession object from the db
     */
    public function getSessionForUser($session_id)
    {
        $result = $this->db->sendQuery("SELECT * FROM SSOSession WHERE master_session_id=:session_id", ['session_id' => $session_id])->fetch();
        return new SSOSession($result['master_session_id'], $result['system_id'], $result['user_id']);
    }

    /** Generates a new session id
     * @param $master_session_id
     * @param $system_id
     * @param $user_id
     * @return mixed
     */
    public function createNewSession($master_session_id, $system_id, $user_id)
    {
        return new SSOSession($master_session_id, $system_id, $user_id);
    }

    /** Saves a session model to the database
     * @param $session SSOSession
     * @return null
     */
    public function saveSession($session)
    {
        $query = "INSERT INTO SSOSession(master_session_id, system_id, user_id) VALUES(:msid, :sid, :uid)";
        $this->db->sendQuery($query, ['msid' => $session->master_session_id, 'sid' => $session->system_id, 'uid' => $session->user_id]);
    }

    /** Generates a Set-Cookie header based on a session model instance
     * @param $session
     * @param $system_name
     * @return string A valid Set-Cookie header with the session information.
     */
    public function getCookieString($session)
    {
        return 'Set-Cookie: SSO_token=' . base64_encode($session->master_session_id) . ';HttpOnly';
    }

    public function deleteSession($session_id) {
        $this->db->sendQuery("DELETE FROM SSOSession WHERE master_session_id=:session_id", ['session_id' => $session_id]);
    }
}