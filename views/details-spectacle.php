<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Détails du spectacle</h1>

<?php

$spec = str_replace('details-spectacle/', '', $this->getPage());

if($spec == 'Coldplay') {

	include BASE_PATH . "/_inc/coldplay.php";

} else if(preg_match("/^les\-enfoires\/(1|2|3)$/", $spec)) {

	$v = intval(str_replace('les-enfoires/', '', $spec));
	
	include BASE_PATH . "/_inc/enfoires-v$v.php";

}