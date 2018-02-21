<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 20-2-2018
 * Time: 14:01
 */

class SystemService
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getSystemByDomain($domain_name) {
        return $this->db->sendQuery("SELECT system_id FROM SystemDomain WHERE domain_name=:origin",
            ['origin' => 'http://' . $domain_name])->fetch()['system_id'];
    }

    public function getSystemNameById($id) {
        return $this->db->sendQuery("SELECT * FROM System WHERE system_id=:id", ['id' => $id])->fetch()['name'];
    }

    public function getSystemByMasterSessionId($master_session_id) {
        $query = "SELECT system_id FROM SSOSession WHERE master_session_id=:master_session_id";
        $params = ['master_session_id' => $master_session_id];
        $system_id = $this->db->sendQuery($query, $params)->fetch();
        return $this->db->sendQuery("SELECT * FROM System WHERE system_id=:system_id", ['system_id' => $system_id])->fetch();
    }

    public function getSystemNames() {
        return $this->db->sendQuery("SELECT name FROM System")->fetchAll();
    }
}