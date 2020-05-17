<?php if(!defined('_DTLR')) exit('Unauthorized');

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
    // récupérer le dernier index de spectacle pour savoir où on se situe niveau PRIMARY KEY
    // car il n'est pas en AUTO INCREMENT...
    $max = intval($this->db->query("SELECT max(NOSPEC) as N FROM LesSpectacles")['data']['N'][0]);

    // requete AJAX
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
                    // convertion date php
                    $d = strtoupper(date('d-M-y', strtotime($date)));

                    $req2 = "INSERT INTO LesRepresentations (NOSPEC, DATEREP) VALUES ($id, '$d')";

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



        // modifier un spectacle
        else if($action == 'editShow') {
            $id = $_POST['noSpec'];
            $name = $_POST['name'];
            $duration = $_POST['duration'];
            $dates = $_POST['dates'];

            $req = "UPDATE LesSpectacles SET NOMS='$name', DUREE=$duration WHERE NOSPEC=$id";

            if($this->db->execute($req) === false) {
                echo "<div id='connexion-state' class='fail'>Une erreur s'est produite</div>";
            }
            
            else {
                // récupération de toutes les dates enregistrées
                $datesRep = $this->db->query("SELECT DATEREP FROM LesRepresentations WHERE NOSPEC=$id")['data']['DATEREP'];

                // on met à jour les dates des représentations
                foreach($dates as $k => $date) {
                    // convertion date php
                    $d = strtoupper(date('d-M-y', strtotime($date)));

                    // on va regarder si la date est dans celles enregistrées
                    // si elle n'y est pas, on l'ajoute (créé), sinon on la laisse
                    // on regarde également les dates à supprimer
                    
                    // n'y est pas: on l'ajoute
                    if(!in_array($d, $datesRep)) {
                        $this->db->query("INSERT INTO LesRepresentations (NOSPEC, DATEREP) VALUES ($id, '$d')");
                    }
                    
                    // y est (encore): on n'y touche pas dans la bdd, mais on l'enlève du tableau enregistré
                    else {
                        unset($datesRep[$k]);
                    }
                }

                // on parcours les dates restantes et on les supprimes de la base de données car plus d'actualité
                foreach($datesRep as $k => $date) {
                    $this->db->query("DELETE FROM LesRepresentations WHERE NOSPEC=$id AND DATEREP='$date'");
                }

                echo "<div id='connexion-state' class='success'>Spectacle mis à jour</div>";
            }
        }

    }


?>



<!-- FORMULAIRE POUR CREER / MODIFIER UN SPECTACLE -->
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

        // re-structure les données spectacle dans un tableau
        // au lieu d'avoir:
        // array(
        //      [NOSPEC]: array(...)
        //      [NOM]: array(...)
        //      ...
        //
        // on a:
        // array(
        //      [index_spectacle(NOSPEC)]: array(NOSPEC, NOM, DUREE, DATES),
        //      ...
        foreach($specs['data']['NOSPEC'] as $k => $noSpec) {

            $spectacles->{$noSpec} = (object)array(
                "NOSPEC"    => $noSpec,
                "NOM"       => $specs['data']['NOMS'][$k],
                "DUREE"     => $specs['data']['DUREE'][$k],
                "DATES"     => []
            );
            
        }

        // on ajoute toutes les représentations pour chaque spectacle
        foreach($repr['data']['NOSPEC'] as $k => $noSpec) {
            $spectacles->{$noSpec}->DATES[] = '<span class="dateRep">'.$repr['data']['DATEREP'][$k].'</span>';
        }
        

        // affichage
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

    <!-- PANNEL EDIT / DELETE -->
    <div id="pannel-spectacle">
        <span id='edit-spec' title='Modifier le spectacle'></span>
        <span id='delete-spec' title='Supprimer le spectacle'></span>
    </div>

</section>

<?php

}