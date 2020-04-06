<?php if(!defined('_DTLR')) exit('Unauthorized');

$tabs = (object)array(
	'Accueil' => '',
	'Billeterie' => 'billeterie',
	'Planning' => 'planning'
);

// LOGGED TABS
if(isset($_SESSION['login'])) {
	$tabs->{'Deconnexion'} = 'administration/deconnexion';
}

// VISITOR TABS
else {
	$tabs->{'Connexion'} = 'administration/connexion';
}

?>

<nav>
    <div id='nav-logo'>
        <span></span>
    </div>

    <div id='box-links'>
		<?php
		foreach($tabs as $name => $link) {
			echo "<a href='$link'>$name</a>";
		}
		?>
    </div>
</nav>