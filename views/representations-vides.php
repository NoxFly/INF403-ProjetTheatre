<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Réservations vides</h1>

<?php

$req = "(SELECT noSpec, dateRep
	FROM
		theatre.LesRepresentations) 
	MINUS
	(SELECT DISTINCT T.noSpec as noSpec, T.dateRep
		FROM
			theatre.LesTickets T,
			theatre.LesRepresentations R
		WHERE
			T.noSpec = R.noSpec AND
			T.dateRep = R.dateRep)";

$cursor = $this->db->execute($req);

if($cursor) {

	$row = oci_fetch_array($cursor, OCI_ASSOC);

	if($row) {

		echo "<table>
			<tr>
				<th>noSpec</th>
				<th>dateRep</th>
			</tr>";

		do {
			$noSpec = $row['NOSPEC'];
			$dateRep = $row['DATEREP'];

			echo "<tr>
				<td>$noSpec</td>
				<td>$dateRep</td>
			</tr>";
		} while($row = oci_fetch_array($cursor, OCI_ASSOC));

		echo "</table>";
	} else {
		echo "<p class='desc'a aucune réservation</p>";
	}
}