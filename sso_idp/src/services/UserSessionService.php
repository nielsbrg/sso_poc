<?php

class UserSessionService implements SessionManagement
{
    private $db;
    private $dateFormat;

    public function __construct($db) {
        $this->db = $db;
        $this->dateFormat = 'Y-m-d H:i:s';
    }

    public function getSessionForUser($system_id, $user_id) {
        $params = ['system_id' => $system_id, 'user_id' => $user_id];
        return $this->db->sendQuery("SELECT * FROM SystemUserSession WHERE system_id=:system_id AND user_id=:user_id", $params)->fetch();
    }

    public function createNewSession($system_id, $user_id)
    {
        $session_id = $this->getNewSessionId();
        $expires_at_timestamp = time() + 60*30; //session expires in 30 mins from now
        $expires_at = date($this->dateFormat, $expires_at_timestamp);
        $created_at = date($this->dateFormat, time());
        return new UserSession($system_id, intval($user_id), $session_id, $expires_at, $expires_at_timestamp, $created_at);
    }

    public function deleteSessionsForUser($system_id, $user_id) {
        $params = ['sid' => $system_id, 'uid' => $user_id];
        $this->db->sendQuery("DELETE FROM SystemUserSession WHERE system_id=:sid AND user_id=:uid", $params);
    }

    public function saveSession($session)
    {
        $params = [
            'sid' => intval($session->system_id),
            'uid' => intval($session->user_id),
            'sessid' => $session->session_id,
            'exp' => $session->expires_at,
            'created' => $session->created_at
        ];
        $this->db->sendQuery("INSERT INTO SystemUserSession(system_id, user_id, session_id, expires_at, created_at) VALUES(:sid, :uid, :sessid, :exp, :created)", $params);
    }

    private function getNewSessionId() {
        session_start();
        $id = session_id();
        $_SESSION = array();
        session_destroy();
        return $id;
    }
}