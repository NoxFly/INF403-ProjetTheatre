<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Gérer les représentations</h1>


<?php

function findSpectacle($aSpectacles, $id) {
    foreach($aSpectacles['NOSPEC'] as $k => $spectacleId) {
        if($spectacleId == $id) {
            return (object)array(
                "NOSPEC" => $id,
                "NOM" => $aSpectacles['NOMS'][$k],
                "DUREE" => $aSpectacles['DUREE'][$k]
            );
        }
    }

    return null;
}

$newSpecButton = "<button class='validate'>Nouveau spectacle</button>";


$repr = $this->db->query("SELECT * FROM LesRepresentations ORDER BY NOSPEC");

if($repr['number_rows'] == 0) {
    echo "<p class='desc'>Aucune représentation</p>";
    echo $newSpecButton;
}

else {

    $specs = $this->db->query("SELECT * FROM LesSpectacles");

    if($specs['number_rows'] == 0) {
        echo "<p class='desc'>Erreur: Il y a des représentations mais pas de spectacle enregistré</p>";
    }
    
    else {

        echo "<p class='desc'>Passez la souris sur un spectacle pour voir les options</p>";
        echo $newSpecButton;

        $spectacles = (object)array();


        foreach($repr['data']['NOSPEC'] as $k => $noSpec) {
            $dateRep = '<span class="dateRep">'.$repr['data']['DATEREP'][$k].'</span>';
            $spectacle = findSpectacle($specs['data'], $noSpec);

            if(!$spectacle) {
                echo "<p class='desc'>Erreur: La représentation $noSpec n'appartient à aucun spectacle</p>";
            }
            
            else {

                if(property_exists($spectacles, $noSpec)) {
                    $spectacles->{$noSpec}->DATES[] = $dateRep;
                } else {
                    $spectacles->{$noSpec} = (object)array(
                        "NOM" => $spectacle->NOM,
                        "DUREE" => $spectacle->DUREE,
                        "DATES" => [$dateRep]
                    );
                }
            }
        }

        foreach($spectacles as $k => $spectacle) {
            echo "<table>";
            
            echo "<tr>
                <th>NOM</th><td><b>".$spectacle->NOM."</b></td>
            </tr>";

            echo "<tr>
                <th>DURÉE</th><td>".$spectacle->DUREE." minutes</td>
            </tr>";

            echo "<tr>
                <th>DATES</th><td>".join($spectacle->DATES, ", ")."</td>
            </tr>";

            echo "</table>";
        }

    }

}

?>

<div id="pannel-spectacle">
    <span id='add-spec' title='Ajouter une date à ce spectacle'></span>
    <span id='edit-spec' title='Modifier le spectacle'></span>
    <span id='delete-spec' title='Supprimer le spectacle'></span>
</div>