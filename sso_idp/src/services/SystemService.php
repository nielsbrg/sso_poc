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

    public function getSystemNames() {
        return $this->db->sendQuery("SELECT name FROM System")->fetchAll();
    }
}