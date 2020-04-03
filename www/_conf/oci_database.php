<?php

class Database {
    private $host;
    private $port;
    private $service_name;
    private $username;
    private $password;

    private $prefix = 'theatre';

    public function __construct($config) {
        // try to connect to the database
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->service_name = $config['service_name'];
        $this->username = $config['username'];
        $this->password = $config['password'];

        $this->db = oci_connect($this->username, $this->password, "//$this->host:$this->port/$this->service_name");
        if(!$this->db) {
            die('<h1>Impossible to connect to the database</h1>');
        }

        // we don't know Oracle / oci, so we can't do the security
    }

    private function query($sql) {
        
    }
}