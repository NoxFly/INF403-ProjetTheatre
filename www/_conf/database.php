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
			$this->db = new PDO("oci:dbname=//$this->host:$this->port/$this->service_name", $this->username, $this->password);
			return true;
		} catch(\PDOException $e) {
			return false;
		}
	}

    private function query($sql, $data = array()) {
		$req = $this->db->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function listTables() {
		$res = $this->query("SELECT table_name, owner FROM all_tables WHERE owner = ?", [$this->prefix]);
		if(!empty($res)) {
			$tables = [];
			foreach($res as $i => $table) {
				$tables[] = $table->TABLE_NAME;
			}
			return $tables;
		}

		return [];
	}
}
