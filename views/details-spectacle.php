<?php if(!defined('_DTLR')) exit('Unauthorized');

$spec = str_replace('details-spectacle/', '', $this->getPage());

$content = [];
if($spec == 'Coldplay') $content = $this->db()->getColdplayTime();

?>


<h1>Détails du spectacle</h1>

<?php

if(empty($content)) {
	echo '<p>Pas de dates de spectacle</p>';
}

else {
	echo '<table>
		<tr><th>Dates de spectacle</th></tr>';
	
	foreach($content as $i => $s) {
		echo "<tr><td>$s</td></tr>";
	}

	echo '</table>';
}