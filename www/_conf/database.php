<?php

class Database {
    private $host;
    private $port;
    private $service_name;
    private $username;
	private $password;
	private $db;

    private $prefix = 'theatre';

    public function __construct($config) {
        $this->host = $config['host'];
        $this->port = $config['port'];
		$this->service_name = $config['service_name'];
		
        $this->username = null;
		$this->password = null;

		$this->db = null;
	}
	
	public function connect($username='', $password='') {
		if(!empty($username) && !empty($password)) {
			$this->username = $username;
			$this->password = $password;
		}

		try {
			$this->db = new PDO("oci:dbname=//$this->host:$this->port/$this->service_name", $this->username, $this->password);
			return true;
		} catch(PDOException $e) {
			return false;
		}
	}

    private function query($sql) {
		
    }
}