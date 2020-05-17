<?php if(!defined('_DTLR')) exit('Unauthorized');

function month($m) {
    switch($m) {
        case '01': return 'JAN';
        case '02': return 'FEB';
        case '03': return 'MAR';
        case '04': return 'APR';
        case '05': return 'MAY';
        case '06': return 'JUN';
        case '07': return 'JUL';
        case '08': return 'AUG';
        case '09': return 'SEP';
        case '10': return 'OCT';
        case '11': return 'NOV';
        case '12': return 'DEC';
    }
}



// create table LesSpectacles and LesRepresentations if they're not existing

$lesSpectacles = $this->db->query("SELECT * FROM LesSpectacles");
$lesRepresentations = $this->db->query("SELECT * FROM LesRepresentations");

$tablesExist = true;

if($lesSpectacles === false || $lesRepresentations === false) {
    $tablesExist = false;
}

echo "<h1>Gérer les représentations</h1>";

if(!$tablesExist) {
    echo "<p class='desc'>Il manque au moins une des deux tables suivantes: LesSpectacles, LesRepresentations</p>";
}

else {
    // get the last index of the shows
    $max = intval($this->db->query("SELECT max(NOSPEC) as N FROM LesSpectacles")['data']['N'][0]);

    if(isset($_POST['action'])) {

        $action = $_POST['action'];

        // créer un spectacle
        if($action == 'newShow') {

            $id = $max + 1;
            $name = $_POST['name'];
            $duration = $_POST['duration'];
            
            // création du spectacle
            $req1 = "INSERT INTO LesSpectacles (NOSPEC, NOMS, DUREE) VALUES ($id, '$name', $duration)";
            $res1 = $this->db->query($req1);

            // ajout des représentations si spectacle créé
            if($res1 === false) {
                echo "<div id='connexion-state' class='fail'>Une erreur s'est produite</div>";
            } else {

                foreach($_POST['dates'] as $k => $date) {
                    $date = explode('-', $date);
                    $d = $date[2].'-'.month($date[1]).'-'.substr($date[0], 2);
                    $req2 = "INSERT INTO LesRepresentations (NOSPEC, DATEREP) VALUES ($id, $d)";

                    $this->db->query($req2);
                }

                echo "<div id='connexion-state' class='success'>Spectacle créé</div>";
            }

        }

        // supprimer un spectacle
        else if($action == 'delete') {

            $id = $_POST['noSpec'];

            $req = "DELETE FROM LesSpectacles WHERE NOSPEC = $id";

            if($this->db->query($req) === false) {
                echo "<div id='connexion-state' class='fail'>Une erreur s'est produite</div>";
            } else {
                echo "<div id='connexion-state' class='success'>Spectacle supprimé</div>";
            }

        }



    }


?>




<section id="window-new-show">

    <form method='post'>

        <h2>Nouveau spectacle</h2>

        <article>

            <input type='text' name='nomSpectacle' placeholder='Nom du spectacle'>

            <input type='number' name='dureeSpectacle' placeholder='Durée (en minutes)' min='0'>

        </article>

        <article>
            <label>Dates des représentations</label>
            <input type='date' name='dateRep' id='dateRepInput'>
            <div id='area-representations'>
                <p class='desc' style='font-size: .8em;'>Aucune date</p>
            </div>
        </article>
        
        
    </form>
    
    <button class='cancel'>Annuler</button>
    <button class='validate'>Confirmer</button>
        
    
</section>






<section id='spectacles'>

    <?php

    $newSpecButton = "<button id='new-show-btn' class='validate'>Nouveau spectacle</button>";


    $repr = $this->db->query("SELECT * FROM LesRepresentations ORDER BY NOSPEC");

    $specs = $this->db->query("SELECT * FROM LesSpectacles");
    

    if($specs['number_rows'] == 0) {
        echo "<p class='desc'>Aucun spectacle enregistré</p>";
        echo $newSpecButton;
    }
    
    else {

        echo "<p class='desc'>Passez la souris sur un spectacle pour voir les options</p>";
        echo $newSpecButton;

        $spectacles = (object)array();

        // re-structure the spectacle data array
        foreach($specs['data']['NOSPEC'] as $k => $noSpec) {

            $spectacles->{$noSpec} = (object)array(
                "NOSPEC"    => $noSpec,
                "NOM"       => $specs['data']['NOMS'][$k],
                "DUREE"     => $specs['data']['DUREE'][$k],
                "DATES"     => []
            );
            
        }

        // then add all shows
        foreach($repr['data']['NOSPEC'] as $k => $noSpec) {
            $spectacles->{$noSpec}->DATES[] = '<span class="dateRep">'.$repr['data']['DATEREP'][$k].'</span>';
        }
        

        // finally display all shows 1 per 1
        foreach($spectacles as $k => $spectacle) {
            
            $id = $spectacle->NOSPEC;

            echo "<table data-id='$id'>";
            
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

    ?>

    <div id="pannel-spectacle">
        <span id='add-spec' title='Ajouter une date à ce spectacle'></span>
        <span id='edit-spec' title='Modifier le spectacle'></span>
        <span id='delete-spec' title='Supprimer le spectacle'></span>
    </div>

</section>

<?php

}