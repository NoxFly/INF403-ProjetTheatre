<?php if(!defined('_DTLR')) exit('Unauthorized');

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
			$this->db = @oci_connect($this->username, $this->password, "//$this->host:$this->port/$this->service_name");

			if(!$this->db) return false;
			return true;
		} catch(Exception $e) {
			return false;
		}
	}

    private function query($sql) {
		$stid = oci_parse($this->db, $sql);
		oci_execute($stid);		
		$nRows = oci_fetch_all($stid, $res);
		return array('data' => $res, 'number_rows' => $nRows);
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

	public function getColdplayTime() {
		$request = ("
			SELECT to_char(daterep,'Day, DD-Month-YYYY HH:MI') as daterep
			FROM $this->prefix.LesRepresentations natural join $this->prefix.LesSpectacles
			WHERE lower(nomS) = lower(:n)
		");

		$stid = oci_parse($this->db, $request);
		$spectacle = 'Coldplay';
		oci_bind_by_name($stid, ':n', $spectacle);

		$ok = @oci_execute($stid);
		$result = [];

		if($ok && $res = oci_fetch($stid)) {
			do {
				$result[] = oci_result($stid, 1);
			} while(oci_fetch($stid));
		}

		oci_free_statement($stid);
		return $result;
	}

	public function getBackrestCategoryInfos($category, $NobackRest) {
		$request = ("
			SELECT noPlace, noRang, noZone, nomS
			FROM $this->prefix.LesSieges natural join $this->prefix.LesZones natural join $this->prefix.LesTickets natural join $this->prefix.LesSpectacles
			WHERE lower(nomC) = lower(:n)
			AND noDossier = $NobackRest
			order by noPlace
		");

		// analyse de la requete et association au curseur
		$stid = oci_parse($this->db, $request);

		// affectation de la variable
		oci_bind_by_name($stid, ':n', $category);

		// execution de la requete
		$ok = @oci_execute($stid);
		$result = [];

		if($ok) {
			$res = oci_fetch($stid);
	
			if($res) {
				do {
					$result[] = (object)array(
						"noPlace" 	=> oci_result($stid, 1),
						"noRang"  	=> oci_result($stid, 2),
						"noZone"  	=> oci_result($stid, 3),
						"nomS" 		=> oci_result($stid, 4)
					);
				} while(oci_fetch($stid));
			}
		}

		oci_free_statement($stid);

		return $result;
	}
}
