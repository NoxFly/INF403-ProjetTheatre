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
			$e = oci_error();
			echo '<h1>Impossible to connect to the database</h1>';
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			die();
        }

        // we don't know Oracle / oci, so we can't do the security
    }

    private function query($sql) {
		$req = oci_parse($this->db, $sql);
		oci_execute($req);
		oci_fetch_all($req, $res);
		return $res;
    }
}