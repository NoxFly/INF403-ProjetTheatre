<?php if(!defined('_DTLR')) exit('Unauthorized');

$categories = ['orchestre', '1er balcon', '2nd balcon', 'poulailler'];

echo '<form><select id="select-specDos">
	<option selected disabled>Catégorie</option>';
foreach($categories as $c) {
	echo "<option>$c</option>";
}
echo '</select></form>';

include BASE_PATH . '/_inc/spec-dos-action.php';