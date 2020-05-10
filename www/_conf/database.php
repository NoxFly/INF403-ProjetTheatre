<?php if(!defined('_DTLR')) exit('Unauthorized');

class Database {
    private $host;
    private $port;
    private $service_name;
    private $username;
	private $password;
	private $link;

    private $prefix = 'THEATRE';

    public function __construct($config) {
        $this->host = $config['host'];
        $this->port = $config['port'];
		$this->service_name = $config['service_name'];
		
        $this->username = null;
		$this->password = null;

		$this->link = null;
	}
	
	public function connect($username='', $password='') {
		if(!empty($username) && !empty($password)) {
			$this->username = $username;
			$this->password = $password;
		}

		try {
			$this->link = @oci_connect($this->username, $this->password, "//$this->host:$this->port/$this->service_name");

			if(!$this->link) return false;
			return true;
		} catch(Exception $e) {
			return false;
		}
	}

	// normally not public but for a homework like this I can
    public function query($sql) {
		$stid = oci_parse($this->link, $sql);
		oci_execute($stid);		

		$nRows = oci_fetch_all($stid, $res);

		return array('data' => $res, 'number_rows' => $nRows);
	}

	// instead of query that returns a result, it returns a pointer / cursor to the result
	public function execute($sql, $bind=null, $params=null,$verbose=TRUE) {
		$stid = oci_parse($this->link, $sql);

		if($bind) oci_bind_by_name($stid, ':n', $bind);

		if($params) $ok = @oci_execute($stid, $params);
		else $ok = @oci_execute($stid);

		if(!$ok) {
			$error_message = oci_error($stid);
			if($verbose){
				echo "<p class='desc'>{$error_message['message']}</p>";
			}
			oci_free_statement($stid);

			return null;
		}

		return $stid;
	}
	
	public function listTables($dbName=null) {
		if(!$dbName) $dbName = $this->prefix;

		$res = $this->query("SELECT table_name, owner FROM all_tables WHERE owner = '$dbName'");


		if(!empty($res['data'])) {
			return $res['data']['TABLE_NAME'];
		}

		return [];
	}

	public function getTableContent($owner, $tableName) {
		return $this->query("SELECT * FROM $owner.$tableName");
	}

	public function cancel() {
		oci_rollback($this->link);
	}

	public function commit() {
		oci_commit($this->link);
	}

	public function displayError($cursor) {
		$e = @oci_error($cursor);
		
		$message = '<p class="desc"><b>';

		switch($e['code']) {
			case 1:
				$message .= "-> contrainte de clef non respectée";
				break;
			case 1400:
				$message .= "-> valeur absente interdite";
				break;
			case 1722:
				$message .= "-> erreur de type, un nombre était attendu";
				break;
			case 2291:
				$message .= "-> contrainte référentielle non respectée";
				break;
			default:
				$message .= "-> autre message: ".$e['code'];
		}

		$message .= '</b><br>('.$e['message'].')</p>';

		echo $message;
	}
}
