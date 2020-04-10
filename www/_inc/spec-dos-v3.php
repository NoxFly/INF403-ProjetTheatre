<?php if(!defined('_DTLR')) exit('Unauthorized');

echo "<form>
	<input type='text' placeholder='No Dossier...' oninput='this.value = this.value.replace(/[^0-9.]/g, \"\");'>
	<button>Chercher</button>
</form>";


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