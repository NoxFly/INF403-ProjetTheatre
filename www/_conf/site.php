<?php

class Site {
    protected $sProtocol 		= null;
	protected $sBaseUrl			= null;
    protected $sBasePath		= null;
    protected $sViewPath        = null;

	// page
	protected $sPage 			= null;

	// page par défaut (homepage)
	protected $sDefaultPage		= 'accueil';

	//
	protected $sMetaTitle		= '';
	protected $sSiteName		= '';


	// contenu
	protected $Content 			= '';
	protected $aConfig			= [];

    function __construct($aConfig) {
        $this->aConfig = $aConfig;

        // set vars
        $this->sBasePath 	= empty($this->aConfig['env']['base_dir']) ? str_replace( DIRECTORY_SEPARATOR.'_conf', '', __DIR__ ) : $this->aConfig['env']['base_dir'];
        $this->sViewPath    = empty($this->aConfig['env']['view_dir']) ? $this->sBasePath.DIRECTORY_SEPARATOR.'/views' : $this->aConfig['env']['view_dir'];
        $this->sProtocol 	= strpos($_SERVER['SERVER_PROTOCOL'],'HTTPS')===0 ? 'https' : 'http' ;
        $this->sBaseDir 	= str_replace(rtrim(str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']), DIRECTORY_SEPARATOR), '', $this->sBasePath);
		$this->sBaseUrl		= str_replace('\\', '/', $this->sBaseDir );
		if($this->sBaseUrl=='') $this->sBaseUrl = '/';

        // pages
        if(!empty($this->aConfig['site']['default_page'])) {
            $this->sDefaultPage = $this->aConfig['site']['default_page'];
        }

        if(!empty($this->aConfig['site']['site_name'])) {
            $this->sSiteName = $this->aConfig['site']['site_name'];
        }

        if(!empty($_SERVER['QUERY_STRING'])) {
          $this->sPage = preg_replace('#[^a-z0-9\/\-]#', '', $_SERVER['QUERY_STRING']);
            // si url fini par / redirige sans le slash
            if(substr($this->sPage, -1) == '/') {
                header('location:'.$this->sBaseUrl . rtrim($this->sPage,'/'));
            }
        } else {
            $this->sPage = $this->sDefaultPage;
        }

        $this->createContent();

        if(preg_match('#<h1>(.*)</h1>#', $this->sContent, $aMatches) && !empty($aMatches[1])) {
            $this->setTitle($aMatches[1]);
        }
    }

    function createContent() {
		ob_start();
		$sIncPage = $this->getPagination();
		include($sIncPage);
		$this->sContent = ob_get_clean();
    }

    function getPagination() {
      	// dossier des pages
		$sPagesPath =  $this->sViewPath.'/';
		
		// pages html
		if(file_exists($sPagesPath.$this->sPage.'.php')) {
			return $sPagesPath.$this->sPage.'.php';
      	}

      	// sinon 404
      	header('HTTP/1.0 404 Not Found');
      	return $sPagesPath.'404.php';
    }
    
    public function setContent($s) {
		$this->sContent = $s;
    }
    
    public function getContent() {
		return $this->sContent;
    }
    
    public function setTitle($s) {
		$this->sMetaTitle = strip_tags($s);
    }
    
    public function getTitle() {
        return empty($this->sMetaTitle)? $this->sSiteName : $this->sMetaTitle;
    }
    
    public function getDefaultPage() {
		return $this->sDefaultPage;
    }
    
    public function getPage() {
		return $this->sPage;
    }
    
    public function getBaseUrl($bAbsolute=false) {
		if($bAbsolute) {
			return $this->sProtocol.'://'.$_SERVER['HTTP_HOST'].$this->sBaseUrl;
        }
        
		return $this->sBaseUrl;
	}
}