<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 20-2-2018
 * Time: 09:12
 */

class SessionProvider
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getSessionForUser($system_id, $user_id) {
        $params = ['system_id' => $system_id, 'user_id' => $user_id];
        return $this->db->sendQuery("SELECT * FROM SystemUserSession WHERE system_id=:system_id AND user_id=:user_id", $params)->fetch();
    }
}