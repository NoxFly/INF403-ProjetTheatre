<?php
/**
 * Class Site
 * 
 * @package ProjetTheatre
 * @author  Dorian Thivolle, Lilian Russo, Timon Roxard
 */

// SECU: pas d'accès direct
if(!defined('_DTLR')) exit('Unauthorized');

class Site {

	/**
	 * @var string protocole utilisé: http ou https
	 */
	protected $sProtocol 		= null;

	/**
	 * @var string chemin URL du projet
	 */
	protected $sBaseUrl			= null;

	/**
	 * @var string chemin de base du projet
	 */
	protected $sBasePath		= null;

	/**
	 * @var string chemin du dossier contenant les pages
	 */
    protected $sViewPath        = null;

	/**
	 * @var string nom de la page à afficher
	 */
	protected $sPage 			= null;

	/**
	 * @var string page par défaut (homepage)
	 */
	protected $sDefaultPage		= 'accueil';

	/**
	 * @var string titre de l'onglet de la page
	 */
	protected $sMetaTitle		= '';

	/**
	 * @var string nom du site
	 */
	protected $sSiteName		= '';


	/**
	 * @var string contenu de la page
	 */
	protected $Content 			= '';

	/**
	 * @var array configuration du site récupéré dans un .ini
	 */
	protected $aConfig			= [];

	/**
	 * @var boolean indique si l'utilisateur est connecté ou non
	 */
	protected $connected		= false;

	/**
	 * @var class base de données Oracle (exceptionnellement en publique pour ce projet)
	 */
	public $db					= null;

	/**
	 * Constructeur de la classe site
	 * @param array $aConfig configuration du site (nom, basepath, ...)
	 */
    function __construct($aConfig) {
        $this->aConfig = $aConfig;

        // set vars
        $this->sBasePath 	= empty($this->aConfig['env']['base_dir']) ? str_replace( DIRECTORY_SEPARATOR.'_conf', '', __DIR__ ) : $this->aConfig['env']['base_dir'];
        $this->sViewPath    = empty($this->aConfig['env']['view_dir']) ? $this->sBasePath.DIRECTORY_SEPARATOR.'/views' : $this->aConfig['env']['view_dir'];
        $this->sProtocol 	= strpos($_SERVER['SERVER_PROTOCOL'],'HTTPS')===0 ? 'https' : 'http' ;
        $this->sBaseDir 	= str_replace(rtrim(str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']), DIRECTORY_SEPARATOR), '', $this->sBasePath);
		$this->sBaseUrl		= str_replace('\\', '/', $this->sBaseDir );
		if($this->sBaseUrl=='') $this->sBaseUrl = '/';

		$this->db = new Database($aConfig['database']);

        // pages
        if(!empty($this->aConfig['site']['default_page'])) {
            $this->sDefaultPage = $this->aConfig['site']['default_page'];
        }

        if(!empty($this->aConfig['site']['site_name'])) {
            $this->sSiteName = $this->aConfig['site']['site_name'];
        }

        if(!empty($_SERVER['QUERY_STRING'])) {
          $this->sPage = preg_replace('#[^a-zA-Z0-9\/\-]#', '', $_SERVER['QUERY_STRING']);
            if(substr($this->sPage, -1) == '/') {
                header('location:'.$this->sBaseUrl . rtrim($this->sPage,'/'));
            }
        } else {
            $this->sPage = $this->sDefaultPage;
        }

    }

	/**
	 * récupère le contenu de la page depuis sont fichier source
	 */
    public function createContent() {
		ob_start();
		$sIncPage = $this->getPagination();
		include($sIncPage);
		$this->sContent = ob_get_clean();

		if(preg_match('#<h1>(.*)</h1>#', $this->sContent, $aMatches) && !empty($aMatches[1])) {
            $this->setTitle($aMatches[1]);
        }
    }

	/**
	 * retourne le chemin du root du site jusqu'à la page suivant la page demandée
	 * @return string chemin jusqu'à la page
	 */
    public function getPagination() {
      	// pages folder
		$sPagesPath =  $this->sViewPath.'/';

		// tables
		if(preg_match("/table\/.+/", $this->sPage)) {
			return $sPagesPath.'table.php';
		}
		
		// details-representation
		if(preg_match("/details\-representation\/.*/", $this->sPage)) {
			return $sPagesPath.'details-representation.php';
		}

		// resa-spectacle
		if(preg_match("/resa-spectacle\/.*/", $this->sPage)) {
			return $sPagesPath.'resa-spectacle.php';
		}

		// spectacle-dossier
		if(preg_match("/spectacle-dossier\/.*/", $this->sPage)) {
			return $sPagesPath.'spectacle-dossier.php';
		}

		// html pages
		if(file_exists($sPagesPath.$this->sPage.'.php')) {
			return $sPagesPath.$this->sPage.'.php';
      	}

      	// else 404
      	header('HTTP/1.0 404 Not Found');
        return $sPagesPath.'404.php';
    }
	
	/**
	 * défini le contenu à afficher
	 * @param string $s contenu
	 */
    public function setContent($s) {
		$this->sContent = $s;
    }
	
	/**
	 * retourne le contenu de la page
	 * @return string
	 */
    public function getContent() {
		return $this->sContent;
    }
	
	/**
	 * défini le titre que l'onglet du site web sur cette page devrait avoir
	 * @param string $s titre de l'onglet
	 */
    public function setTitle($s) {
		$this->sMetaTitle = strip_tags($s);
    }
	
	/**
	 * retourne le titre de la page du site
	 * @return string titre de la page
	 */
    public function getTitle() {
        return empty($this->sMetaTitle)? $this->sSiteName : $this->sMetaTitle;
    }
	
	/**
	 * retourne la page par défaut
	 * @return string nom de la page par défaut
	 */
    public function getDefaultPage() {
		return $this->sDefaultPage;
    }
	
	/**
	 * retourne le nom de la page à afficher
	 * @return string nom de la page
	 */
    public function getPage() {
		return $this->sPage;
    }
	
	/**
	 * retourne l'URL du projet
	 * @return string url du projet
	 */
    public function getBaseUrl($bAbsolute=false) {
		if($bAbsolute) {
			return $this->sProtocol.'://'.$_SERVER['HTTP_HOST'].$this->sBaseUrl;
        }
        
		return $this->sBaseUrl;
	}


	/**
	 * Défini l'état de connexion
	 * @param  boolean $state	état de la connexion
	 * @return void
	 */
	public function setConnection($state) {
		$this->connected = $state;
	}

	/**
	 * Indique l'état de connexion de l'utilisateur
	 * @return boolean
	 */
	public function isConnected() {
		return $this->connected;
	}
}