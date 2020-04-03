<?php

class Database {
    private $host;
    private $database;
    private $username;
    private $password;

    private $prefix = 'theatre';

    public function __construct($config) {
        // try to connect to the database
        $this->host = $config['host'];
        $this->database = $config['service_name'];
        $this->username = $config['username'];
        $this->password = $config['password'];

        try {
            $this->db = new PDO("mysql:host=$this->host; dbname=$this->database", $this->username, $this->password, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
            ));
        } catch(PDOException $e) {
            die('<h1>Impossible to connect to the database</h1>');
        }
    }

    private function query(?string $sql, $data = array()) {
        $req = $this->db->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
}