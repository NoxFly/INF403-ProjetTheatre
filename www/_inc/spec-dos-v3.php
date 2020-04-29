<?php if(!defined('_DTLR')) exit('Unauthorized');

$lesPlaces = $this->db()->getTableContent('LesPlaces');
$n = $lesPlaces['number_rows'];
$lesPlaces = $lesPlaces['data'];

echo '<form><select>
	<option selected disabled>Place</option>';
	for($i=0; $i<$n; $i++) {
		$p = $lesPlaces['NOPLACE'][$i];
		$r = $lesPlaces['NORANG'][$i];
		$z = $lesPlaces['NOZONE'][$i];
		echo "<option>$p-$r-$z</option>";
	}
echo '</select>';

if(false) {

	$categories = $this->db()->getTableContent('lescategories')['data']['NOMC'];

	echo '<form><select id="select-specDos">
		<option selected disabled>Catégorie</option>';

	foreach($categories as $c) {
		echo "<option>$c</option>";
	}

	echo '</select></form>';

	include BASE_PATH . '/_inc/spec-dos-action.php';
}

echo '</form>';