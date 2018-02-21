<?php

class UserSessionService extends BaseSessionService implements SessionManagement
{
    private $db;
    private $dateFormat;

    public function __construct($db) {
        parent::__construct('D, d M Y H:i:s');
        $this->db = $db;
        $this->dateFormat = 'Y-m-d H:i:s';
    }

    public function getSessionForUser($session_id) {
        $query = "SELECT * FROM SystemUserSession WHERE child_session_id=:session_id";
        $params = ['session_id' => $session_id];
        $session = $this->db->sendQuery($query, $params)->fetch();
        $expires_at_timestamp = DateTime::createFromFormat($dateFormat, $session->expires_at)->getTimestamp();
        return new UserSession($session['master_session_id'], $session['system_id'], $session['child_session_id'],
            $session['expires_at'], $expires_at_timestamp, $session['created_at']);
    }

    public function saveSession($session) {
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

    public function createNewSession($master_session_id, $system_id) {
        $expires_at_timestamp = time() + 60*30; //session expires in 30 mins from now
        $expires_at = date($this->dateFormat, $expires_at_timestamp);
        $created_at = date($this->dateFormat, time());
        return new UserSession($master_session_id, $system_id, $this->getNewSessionId(), $expires_at, $expires_at_timestamp, $created_at);
    }

    public function deleteSessionsForUser($master_session_id) {
        $this->db->sendQuery("DELETE FROM SystemUserSession WHERE master_session_id=:msid", ['msid' => $master_session_id]);
    }

    public function getCookieString($session, $system_name) {
        return 'Set-Cookie: ' . 'session_id_' . $system_name . '='
            . $session->session_id . ';HttpOnly' .
            ';Expires=' . date($this->expiresFormat, $session->expires_at_timestamp);
    }
}