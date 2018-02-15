<?php

class DatabaseConnection
{
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPassword;

    private $connection;

    public function __construct($host, $name, $user, $pass) {
        $this->dbHost = $host;
        $this->dbName = $name;
        $this->dbUser = $user;
        $this->dbPassword = $pass;

        $this->createConnection($host, $name, $user, $pass);
    }

    /** Method to send query as prepared statements to the database.
     * @param $sql The SQL query as a string. Parameters are replaced with ':' i.e. :name
     * @param array $params An associative array with the parameter name as key and the param value as value
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function sendQuery($sql, $params = []) {
        if(!$this->checkConnection() && !$this->createConnection($this->dbHost, $this->dbName, $this->dbUser, $this->dbPassword)) {
            return false;
        }

        $this->beginTransaction();
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            $this->commitTransaction();
            return $stmt;
        }
        catch(PDOException $e) {
            $this->rollback();
            var_dump($e);
        }
    }

    private function createConnection($host, $name, $user, $pass) {
        $this->connection = new PDO('mysql:host='.$host.';dbname='.$name.';charset=utf8mb4', $user, $pass);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->checkConnection();
    }

    private function checkConnection()
    {
        return isset($this->connection) && !empty($this->connection);
    }

    private function beginTransaction() {
        $this->connection->beginTransaction();
    }

    private function commitTransaction() {
        $this->connection->commit();
    }

    private function rollback() {
        $this->connection->rollback();
    }
}