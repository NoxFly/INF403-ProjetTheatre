<?php if(!defined('_DTLR')) exit('Unauthorized');

// recover all tables from the base THEATRE
$req = "SELECT table_name from all_tables where owner='THEATRE'";

$content = $this->db->query($req);


// display all THEATRE TABLES
echo '<table>
		<tr><th>Tables de la base THEATRE</th></tr>';

		if($content['number_rows'] == 0) {
			$size = count(array_keys($content['data']));
			echo "<td colspan='$size' style='text-align: center; color: #222;'>Aucun contenu</td>";
        }
        
        else {

			for($i=0; $i < $content['number_rows']; $i++) {
                echo '<tr>';
                
				foreach(array_keys($content['data']) as $k) {
                    echo '<td>'.$content['data'][$k][$i].'</td>';
                }
                
				echo '</tr>';
            }
            
		}

echo '</table>';






// TREATMENT

// delete imported tables / all tables
if(isset($_POST["del"]) || isset($_POST["del_everything"])) {
    $all_table = $this->db->listTables('THEATRE');
    $all_user_table = $this->db->listTables(strtoupper($_SESSION['login']));

    if(empty($all_table)) {
        echo '<p class="desc">Pas de contenu à supprimer</p>';
    }

    else {

        foreach($all_user_table as $table) {

            if(isset($_POST["del_everything"]) || in_array($table, $all_table)) {
                $req = "DROP table $table";
                $this->db->query($req);
            }
        }
    }
}


// import all THEATRE tables
if(isset($_POST["import"])) {

    $all_table = $this->db->listTables('THEATRE');

    if(empty($all_table)) {
        echo '<p class="desc">Pas de contenu à transférer</p>';
    }

    else {

        foreach($all_table as $table) {
            $req = "CREATE table $table as (select * from THEATRE.$table)";
            $this->db->query($req, null, null);
        }

    }
}



// display user tables
$login = $_SESSION['login'];

$content = $this->db->listTables(strtoupper($login));

echo "<table>
    <tr>
        <th>Tables de ".strtoupper($login)."</th>
    </tr>";

foreach($content as $col) {
    echo "<tr>
        <td>$col</td>
    </tr>";
}

echo "</table>";


?>


<!-- ACTION BUTTONS -->
<form action="" method="POST">
    <button type="submit" value="OK" name="import" class='validate'>Tranfert vers votre base locale</button>
    <button type="submit" value="RESET" name="del" class='delete'>Supprimer les tables importées</button>
    <button type="submit" value="RESET" name="del_everything" class='delete'>Supprimer toutes les tables</button>
</form>