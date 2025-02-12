<?php if(!defined('_DTLR')) exit('Unauthorized');

class Database {
	// variables
    private $host;
    private $port;
    private $service_name;
    private $username;
	private $password;
	private $link;

    private $prefix = 'THEATRE';

	/**
	 * constructeur de la clase Database
	 * @param array $config configuration de la base de donnée (host, db, name, psswd, ...)
	 */
    public function __construct($config) {
        $this->host = $config['host'];
        $this->port = $config['port'];
		$this->service_name = $config['service_name'];
		
        $this->username = null;
		$this->password = null;

		$this->link = null;
	}
	
	/**
	 * essaie d'établir une connection entre le site et la base de donnée Oracle
	 * @param  string $username nom d'utilisateur de la base de donnée
	 * @param  string $password mot de passe utilisateur
	 * @return bool   si la connection a réussie ou non
	 */
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

	/**
	 * normalement private mais pour ce projet on le met public
	 * execute une reqête SQL
	 * @param  string $sql
	 * @return array|bool false si la requête n'abouti pas, sinon le résultat
	 */
    public function query($sql) {
		$stid = oci_parse($this->link, $sql);
		$ok = @oci_execute($stid);

		if(!$ok) return false;

		if(strpos($sql, 'SELECT') !== false) {
			$nRows = @oci_fetch_all($stid, $res);
			return array('data' => $res, 'number_rows' => $nRows);
		}
	}

	/**
	 * pareil que la méthode query, mais renvoie un curseur et non un résultat complet (fetch_all)
	 * permet également une verbose (par défaut true)
	 * @param  string $sql     requête
	 * @param  string $bind    si on doit focus une ligne dans la requête
	 * @param  object $params  paramètres de la reqête (par défaut aucun)
	 * @param  bool   $verbose verbose ou non
	 * @return object|bool curseur ou false, si la requête n'a pas abouti
	 */
	public function execute($sql, $bind=null, $params=null, $verbose=TRUE) {
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

			return false;
		}

		return $stid;
	}
	
	/**
	 * renvoie le nom de toutes les tables d'une base donnée
	 * @param  string @dbName nom de la base
	 * @return array liste des noms des tables
	 */
	public function listTables($dbName=null) {
		if(!$dbName) $dbName = $this->prefix;

		$res = $this->query("SELECT table_name, owner FROM all_tables WHERE owner = '$dbName'");


		if(!empty($res['data'])) {
			return $res['data']['TABLE_NAME'];
		}

		return [];
	}

	/**
	 * retourne le contenu d'une table suivant sont nom et sa base
	 * @return object
	 */
	public function getTableContent($owner, $tableName) {
		return $this->query("SELECT * FROM $owner.$tableName");
	}

	/**
	 * annule une requête
	 */
	public function cancel() {
		oci_rollback($this->link);
	}

	/**
	 * finalise une requête
	 */
	public function commit() {
		oci_commit($this->link);
	}

	/**
	 * affiche une erreur depuis un curseur
	 * @param  object $cursor curseur de la requête
	 */
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
