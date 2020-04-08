<?php if(!defined('_DTLR')) exit('Unauthorized');

$tabs = [
	['Accueil', '']
];

// LOGGED TABS
if($oSite->isConnected()) {
	$tabs[] = ['Tables', 'tables'];
	$tabs[] = ['Tickets', 'table/lestickets'];
	$tabs[] = ['Spectacles', 'table/lesspectacles'];
	$tabs[] = ['<span class="logo-logout"><span></span></span>', 'administration/deconnexion'];
}

// VISITOR TABS
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