<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Projet Théâtre</h1>

<?php

// if the user is not connected, then show the connection button
if(!$this->isConnected()) {
	echo "<a class='btn home-ctn' href='administration/connexion'>Se connecter</a>";
}


// show the content if the user is connected
else {
	
// assez court donc la flemme de le faire en tableau php avec une boucle	
?>


<article>
	<h3>Contenu des relations de la base de données</h3>
		<a href="tables" class='summary-box'>Contenu des relations fournies</a>
		<a href="tables-personnelles" class='summary-box'>Relations appartenant au compte connecté</a>
</article>

<article>
	<h3>Reqêtes fournies (observer le comportement et le code) sur le BD fournie</h3>
		<a href="details-representation/Coldplay" class='summary-box'>Représentation(s) Coldplay</a>
		<a href="spectacle-dossier/11" class='summary-box'>Pour les spectacles réservés par le dossier No 11, donner les places d'une catégorie donnée</a>
</article>

<article>
	<h3>Reqêtes à modifier sur la BD fournie</h3>
		<a href="details-ticket" class='summary-box'>Afficher les détails d'un ticket</a>
		<a href="spectacle-dossier/v1/11" class='summary-box'>Pour les spectacles réservés par le dossier No 11, donner les places d'une catégorie donnée<br>(version améliorée 1)</a>
		<a href="spectacle-dossier/v2/11" class='summary-box'>Pour les spectacles réservés par le dossier No 11, donner les places d'une catégorie donnée<br>(version améliorée 2)</a>
		<a href="spectacle-dossier/v3" class='summary-box'>Pour les spectacles réservés par le dossier No 11, donner les places d'une catégorie donnée<br>(version améliorée 3)</a>
</article>

<article>
	<h3>Reqêtes à réaliser sur la BD fournie</h3>
		<a href="representations-vides" class='summary-box'>Afficher les représentations sans place réservée</a>
		<a href="resa-spectacle/2" class='summary-box'>Pour chaque spectacle, donner son numéro, son nom, les dates de ses représentations et pour chacune le nombre de places réservées<br>(version avec deux curseurs)</a>
		<a href="resa-spectacle/1" class='summary-box'>Pour chaque spectacle, donner son numéro, son nom, les dates de ses représentations et pour chacune le nombre de places réservées<br>(version avec un seul curseur)</a>
</article>

<article>
	<h3>Reqêtes fournies (obeserver le comportement et le code) sur la BD à créer</h3>
		<a href="details-representation/les-enfoires/1" class='summary-box'>Une nouvelle représentation du spectacle "Les enfoirés" est programmée le 29/02/2016 (version 1)</a>
		<a href="details-representation/les-enfoires/2" class='summary-box'>Une nouvelle représentation du spectacle "Les enfoirés" est programmée le 29/02/2016 (version 2)</a>
		<a href="details-representation/les-enfoires/3" class='summary-box'>Une nouvelle représentation du spectacle "Les enfoirés" est programmée le 29/02/2016 (version 3)</a>
</article>

<article>
	<h3>Tâches à réaliser sur la BD à créer</h3>
		<a href="gerer-reservations" class='summary-box'>Gérer les réservations</a>
		<a href="gerer-representations" class='summary-box'>Gérer les représentations</a>
</article>
<article>
	<h3>Tansfert de base de donnée</h3>
		<a href="transfert" class="summary-box">Transferer les donnée de la base THEATRE vers la base locale</a>
</article>


<?php  } ?>