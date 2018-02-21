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
        parent::__construct('D, d M Y H:i:s');
        $this->db = $db;
    }

    public function getSessionForUser($session_id)
    {
        $result = $this->db->sendQuery("SELECT * FROM SSOSession WHERE master_session_id=:session_id", ['session_id' => $session_id])->fetch();
        return new SSOSession($result['master_session_id'], $result['system_id'], $result['user_id']);
    }

    public function saveSession($session)
    {
        $query = "INSERT INTO SSOSession(master_session_id, system_id, user_id) VALUES(:msid, :sid, :uid)";
        $this->db->sendQuery($query, ['msid' => $session->master_session_id, 'sid' => $session->system_id, 'uid' => $session->user_id]);
    }

    public function createNewSession($master_session_id, $system_id, $user_id)
    {
        return new SSOSession($master_session_id, $system_id, $user_id);
    }

    public function getCookieString($session)
    {
        return 'Set-Cookie: SSO_token=' . base64_encode($session->master_session_id) . ';HttpOnly'
            . ';Expires=' . date($this->expiresFormat, time() + 30*60);
    }

    public function deleteSession($session_id) {
        $this->db->sendQuery("DELETE FROM SSOSession WHERE master_session_id=:session_id", ['session_id' => $session_id]);
    }
}