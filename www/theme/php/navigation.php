<?php if(!defined('_DTLR')) exit('Unauthorized');

$tabs = [
	['Accueil', '']
];

// ONGLETS D'UTILISATEUR CONNECTE
if($oSite->isConnected()) {
	$tabs[] = ['Tables', 'tables'];
	$tabs[] = [ucfirst($_SESSION['login']), 'tables-personnelles'];
	$tabs[] = ['Spectacles', 'table/THEATRE/lesspectacles'];
	$tabs[] = ['<span class="logo-logout"><span></span></span>', 'administration/deconnexion'];
}

// ONGLETS VISITEUR
else {
	$tabs[] = ['Connexion', 'administration/connexion'];
}

?>

<nav>
    <div id='nav-logo'>
        <span></span>
    </div>

    <div id='box-links'>
		<?php
		foreach($tabs as $i => $tab) {
			echo "<a href='$tab[1]'>$tab[0]</a>";
		}
		?>
    </div>
</nav>