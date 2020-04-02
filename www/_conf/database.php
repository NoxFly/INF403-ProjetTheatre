<?php

class Database {
    private $host;
    private $port;
    private $service_name;
    private $username;
    private $password;

    private $prefix = 'theatre';

    public function __construct($host, $service_name, $port, $username, $password) {
        // try to connect to the database
        $this->host = $host;
        $this->port = $port;
        $this->service_name = $service_name;
        $this->username = $username;
        $this->password = $password;

        $this->db = oci_connect($this->username, $this->password, "//$this->host:$this->port/$this->service_name");
        if(!$this->db) {
            die('<h1>Impossible to connect to the database</h1>');
        }

        // we don't know Oracle / oci, so we can't do the security
    }

    private function query($sql, $data = array()) {
        
    }
}