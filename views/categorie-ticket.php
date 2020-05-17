<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Catégorie Ticket</h1>

<?php

// get all spectacles
$liste_spectacles = $this->db->query("SELECT nospec, noms from lesspectacles");
$final = array();


// si la table LesSpectacles n'existe pas
if(!$liste_spectacles) {
    echo "<p class='desc'>La table LesSpectacle n'existe pas</p>";
}

// si la table LesSpectacles existe
else {

    $content = $this->db->query("SELECT distinct NOSPEC from LESTICKETS");

    // la table LesTickets n'existe pas
    if(!$content) {
        echo "<p class='desc'>La table LesTickets n'existe pas</p>";
    }

    // la table LesTickets existe
    else {

        $possible = $content["data"]["NOSPEC"];

        for($i = 0;$i<$liste_spectacles["number_rows"];$i++) {
            $final[$liste_spectacles["data"]["NOSPEC"][$i]] = $liste_spectacles["data"]["NOMS"][$i];
        }

        echo"<table>
            <tr>
                <th>Spectacle</th>
                <th>Tickets disponibles</th>
            </tr>";

        foreach($possible as $key => $value) {
            $nb_ticket = $this->db->query("SELECT count(noserie) from LESTICKETS where nospec=$value");
            $nb_ticket = $nb_ticket["data"]["COUNT(NOSERIE)"][0];
            echo "<tr>
                <th>".$final[$value]."</th>
                <td>".$nb_ticket."</td>
            </tr>";
        }

        foreach($final as $key => $value) {
            if(!in_array($key,$possible)) {
                echo "<tr>
                    <th>".$final[$key]."</th>
                    <td>complet</td>
                </tr>";
            }
        }

        echo "</table>";
    }
}