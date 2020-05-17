<?php if(!defined('_DTLR')) exit('Unauthorized');

// requete
$req = "SELECT count(noSerie) as noSerie, noSpec, dateRep, nomS
		FROM
			(SELECT T.noSerie as noSerie, R.noSpec as noSpec, R.dateRep as dateRep, S.nomS as nomS
				FROM
					theatre.LesSpectacles S,
					theatre.LesRepresentations R,
					theatre.LesTickets T
				WHERE
					T.noSpec = R.noSpec AND
					T.dateRep = R.dateRep AND
					S.noSpec = R.noSpec)
		GROUP BY
			noSpec, dateRep, nomS";

$cursor = $this->db->execute($req);


// on trouve un résultat
if($cursor) {

	$row = oci_fetch_array($cursor, OCI_ASSOC);

	// affichage
	if($row) {

		echo "<table>
			<tr>
				<th>noSpec</th>
				<th>dateRep</th>
				<th>nomS</th>
				<th>nbPlacesRes</th>
			</tr>";

		do {

			$noSpec = $row['NOSPEC'];
			$dateRep 	= $row['DATEREP'];
			$nomS 		= $row['NOMS'];
			$noSerie 	= $row['NOSERIE'];

			echo "<tr>
				<td>$noSpec</td>
				<td>$dateRep</td>
				<td>$nomS</td>
				<td>$noSerie</td>
			</tr>";

		} while($row = oci_fetch_array($cursor, OCI_ASSOC));

		echo "</table><br>";

	} else {

		echo "<p class='desc'>Le résultat de la requête est vide</p>";

	}
} else {

	echo "<p class='desc'a été trouvé</p>";

}