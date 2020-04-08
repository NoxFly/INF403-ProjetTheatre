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
		
		/**/$nRows = oci_fetch_all($stid, $res);
		return array('data' => $res, 'number_rows' => $nRows);/**/

		/* $res = [];
		while($row = oci_fetch_array($stid, OCI_ASSOC)){
			$res[] = $row;
		}

		$nRows = count($res);

		return array('data' => $res, 'number_rows' => $nRows); */
	}
	
	public function listTables() {
		$res = $this->query("SELECT table_name, owner FROM all_tables WHERE owner = '$this->prefix'");
		if(!empty($res['data'])) {
			return $res['data']['TABLE_NAME'];
		}

		return [];
	}

	public function getTableContent($tableName) {
		return $this->query("SELECT * FROM $this->prefix.$tableName");
	}
}
