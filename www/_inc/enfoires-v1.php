<?php

$reqs = [
	"INSERT INTO LesSpectacles
		VALUES (120, 'Les enfoires')",
	"INSERT INTO LesRepresentations
		VALUES (120, to_date('29-02-2016 20:00', 'DD-MM-YYYY HH24:MI'))"
];

$cursor = $this->db->execute($reqs[0], null, OCI_NO_AUTO_COMMIT);

if($cursor) {
	$cursor = $this->db->execute($reqs[1], null, OCI_NO_AUTO_COMMIT);

	if($cursor) {
		// confirm the transaction
		echo '<p class="desc">La mise à jour a été effectuée</p>';
		$this->db->commit();
	}


	else {
		// cancel the transaction
		echo '<p class="desc">La mise à jour a été rejetée</p>';
		$this->db->cancel();
	}
}


else {
	// cancel the transaction
	echo '<p class="desc">La mise à jour a été rejetée</p>';
	$this->db->cancel();
}

@oci_free_statement($cursor);