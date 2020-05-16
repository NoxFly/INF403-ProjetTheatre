<?php

$req = "SELECT table_name from all_tables where owner='THEATRE'";

$content = $this->db->query($req);

echo '<table>
		<tr><th>Tables de la base THEATRE</th></tr>';

		if($content['number_rows'] == 0) {
			$size = count(array_keys($content['data']));
			echo "<td colspan='$size' style='text-align: center; color: #222;'>Aucun contenu</td>";
		} else {

			for($i=0; $i < $content['number_rows']; $i++) {
				echo '<tr>';
				foreach(array_keys($content['data']) as $k) {
                    echo '<td>'.$content['data'][$k][$i].'</td>';
				}
				echo '</tr>';
			}
		}

echo '</table>';

if(isset($_POST["del"])){
    $all_table = $this->db->listTables('THEATRE');
    if(empty($all_table)){
        echo 'Pas de contenu';
    }
    else{
        foreach($all_table as $table){
            $success = TRUE;
            $req = "DROP table $table";
            $rep = $this->db->execute($req,null,null,FALSE);
            if(!$rep){
                echo "<div id='connection-state' class='fail'>Erreur: les fichiers ont déjà été supprimé ou n'ont jamais été importé</div>";
                $success = FALSE;
                break;
            }
        }
        if($success) echo "<div id='connection-state' class='success'>Opération réussie</div>";
    }
}

if(isset($_POST["set"])){
    $all_table = $this->db->listTables('THEATRE');
    if(empty($all_table)){
        echo 'Pas de contenu';
    }
    else{        
        foreach($all_table as $table){
            $success = TRUE;
            $req = "CREATE table $table as (select * from THEATRE.$table)";
            $rep = $this->db->execute($req,null,null,FALSE);
            if(!$rep){
                echo "<div id='connection-state' class='fail'>Erreur: les fichiers ont sans doute déjà été importé</div>";
                $success = FALSE;
                break;
            }
        }
        if($success) echo "<div id='connection-state' class='success'>Opération réussie</div>";
    }
}

$login = $_SESSION['login'];

$content = $this->db->listTables(strtoupper($login));

echo "<table>
		<tr><th>Tables de ".$login."</th></tr>";
foreach($content as $col){
    echo "<tr><td>$col</td></tr>";

}
echo "</table>";


?>

<form action="" method="POST">
    <button type="submit" value = "OK" name="set" class='validate'>Tranfert vers votre base locale</button>
    <button type="submit" value = "RESET" name="del" class='delete'>Supprimer les tables importées</button>
</form>