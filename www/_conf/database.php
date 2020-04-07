<?php

class Database {
    private $host;
    private $port;
    private $service_name;
    private $username;
	private $password;
	private $db;

    private $prefix = 'THEATRE';

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
			$this->db = oci_connect($this->username, $this->password, "//$this->host:$this->port/$this->service_name");

			if(!$this->db) return false;
			return true;
		} catch(Exception $e) {
			return false;
		}
	}

    private function query($sql) {
		$stid = oci_parse($this->db, $sql);
		oci_execute($stid);
		oci_fetch_all($stid, $res);
		return $res;
	}
	
	public function listTables() {
		$res = $this->query("SELECT table_name, owner FROM all_tables WHERE owner = '$this->prefix'");
		if(!empty($res)) {
			return $res['TABLE_NAME'];
		}

		return [];
	}
}
