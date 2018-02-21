<?php

class UserSessionService extends BaseSessionService implements SessionManagement
{
    private $db;
    private $dateFormat;
    private $expiresFormat;

    public function __construct($db) {
        $this->db = $db;
        $this->dateFormat = 'Y-m-d H:i:s';
        $this->expiresFormat = 'D, d M Y H:i:s';
    }

    public function getUserBySession($master_session_id) {
    }

    public function getSessionForUser($master_session_id) {
        //check if exists

        $query = "SELECT * FROM SystemUserSession WHERE master_session_id=:master_session_id";
        $session = $this->db->sendQuery($query, ['master_session_id' => $master_session_id])->fetchAll();
        if($session) {
            $expires_at_timestamp = DateTime::createFromFormat($this->dateFormat, $session['expires_at'])->getTimestamp();
            return new UserSession($session['system_id'], $session['user_id'], $session['session_id'],
                $session['expires_at'], $expires_at_timestamp ,$session['created_at']);
        }
        return null;
    }

    public function createNewSession($master_session_id, $system_id)
    {
        $expires_at_timestamp = time() + 60*30; //session expires in 30 mins from now
        $expires_at = date($this->dateFormat, $expires_at_timestamp);
        $created_at = date($this->dateFormat, time());
        return new UserSession($master_session_id, $system_id, $this->getNewSessionId(), $expires_at, $expires_at_timestamp, $created_at);
    }

    public function deleteSessionsForUser($master_session_id) {
        $this->db->sendQuery("DELETE FROM SystemUserSession WHERE master_session_id=:msid", ['msid' => $master_session_id]);
    }

    public function saveSession($session)
    {
        $query = "INSERT INTO SystemUserSession(master_session_id, child_session_id, system_id, expires_at, created_at) 
                  VALUES(:msid, :sessid, :sysid, :exp, :created)";
        $params = [
            'msid' => $session->master_session_id,
            'sessid' => $session->session_id,
            'sysid' => intval($session->system_id),
            'exp' => $session->expires_at, 'created' => $session->created_at
        ];
        $this->db->sendQuery($query, $params);
    }

    /** Generates a Set-Cookie header based on a session model instance
     * @param $session
     * @param $system_name
     * @return string A valid Set-Cookie header with the session information.
     */
    public function getCookieString($session, $system_name)
    {
        return 'Set-Cookie: ' . 'session_id_' . $system_name . '='
            . $session->session_id . ';HttpOnly' .
            ';Expires=' . date($this->expiresFormat, $session->expires_at_timestamp);
    }
}