<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Catégorie Ticket</h1>

<?php

$list_spectables = $this->db->query("SELECT nospec, noms from lesspectacles");
$final = array();

for($i = 0;$i<$list_spectables["number_rows"];$i++){
    $final[$list_spectables["data"]["NOSPEC"][$i]] = $list_spectables["data"]["NOMS"][$i];
}

$content = $this->db->query("SELECT distinct NOSPEC from LESTICKETS");

$possible = $content["data"]["NOSPEC"];

echo"<table>
    <tr>
        <th>Spectacle</th>
        <th>Tickets disponibles</th>
    </tr>";

foreach($possible as $key=>$value){
    $nb_ticket = $this->db->query("SELECT count(noserie) from LESTICKETS where nospec=$value");
    $nb_ticket = $nb_ticket["data"]["COUNT(NOSERIE)"][0];
    echo "<tr>
        <th>".$final[$value]."</th>
        <td>".$nb_ticket."</td>
    </tr>";
}

foreach($final as $key=>$value){
    if(!in_array($key,$possible)){
        echo "<tr>
            <th>".$final[$key]."</th>
            <td>complet</td>
        </tr>";
    }
}

echo "</table>";