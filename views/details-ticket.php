<?php if(!defined('_DTLR')) exit('Unauthorized');


$req = "SELECT noSerie FROM theatre.LesTickets ORDER BY noSerie";

$stid = $this->db()->execute($req);


$res = oci_fetch($stid);


?>

<h1>Détail du ticket</h1>

<?php


if(!$res) {

    // il n'y a aucun résultat
    echo "<p style='text-align: center; color: #444; margin-bottom: 100px;'>Aucun ticket dans la base de donnée</p>";

} else {

    // on affiche le formulaire de sélection
    echo "
        <form action='DetailsTicket_action.php' method='post'>
            <label for='sel_noSerie'>Sélectionnez un ticket :</label>
            <select id='sel_noSerie' name='noSerie'>
    ";

        // création des options
        do {

            $noSerie = oci_result($stid, 1);
            echo "<option value='$noSerie'>$noSerie</option>";

        } while($res = oci_fetch($stid));

    echo "
            </select>
            <br/><br/>
            <button>Valider</button>
        </form>
    ";

}


// on libère le curseur
oci_free_statement($stid);

// travail à réaliser
echo "
    <p style='text-align: center; color: #444;'>
        Modifiez cet enchaînement de scripts afin d'afficher pour chaque ticket, en plus des informations déjà existantes, sa date d'émission et son numéro de dossier.
    </p>
";
