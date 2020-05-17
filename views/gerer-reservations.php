<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Gérer les réservations</h1>

<?php

function add_ticket($db){
    //Fonction qui va vérifier que toutes les valeurs son bonens avant d'éxécuter la requète
    $verif_noSerie = $db->query("SELECT noSerie from LesTickets where noSerie=".$_POST["noSerie"]);
    if($verif_noSerie["number_rows"]){
        return "<div id='connection-state' class='fail'>Le numéro du ticket existe déjà</div>";
    }
    unset($verif_noSerie);
    $verif_noSpec = $db->query("SELECT noSpec from LesTickets where noSpec=".$_POST["noSpec"]);
    if(!$verif_noSpec["number_rows"]){
        return "<div id='connection-state' class='fail'>Le spéctacle n'existe pas</div>";
    }
    unset($verif_noSpec);
    $_POST["dateRep"] = strtoupper(date('d-M-y',strtotime($_POST["dateRep"])));
    $verif_dateRep = $db->query("SELECT dateRep from LesTickets where dateRep=".$_POST["dateRep"]);
    if($verif_dateRep["number_rows"]){
        return "<div id='connection-state' class='fail'>La date n'est pas valide</div>";
    }
    unset($verif_dateRep);
    $verif_noPlace = $db->query("SELECT noPlace from LesTickets where noPlace=".$_POST["noPlace"]."AND noSpec=".$_POST["noSpec"]."AND dateRep=".$_POST["dateRep"]);
    if($verif_noPlace["number_rows"]){
        return "<div id='connection-state' class='fail'>La place est déjà prise</div>";
    }
    unset($verif_noPlace);
    $_POST["dateEmission"] = "21-FEB-17";
    $rep = $db->execute("INSERT into LesTickets (NOSERIE, NOSPEC, DATEREP, NOPLACE, NORANG, DATEEMISSION, NODOSSIER) values (".$_POST["noSerie"].", ".$_POST["noSpec"].", '".$_POST["dateRep"]."', ".$_POST["noPlace"].", ".$_POST["noRang"].", '".$_POST["dateEmission"]."', ".$_POST["noDossier"].")");
    if($rep){
        $db->commit();
        return "<div id='connection-state' class='sucess'>Ticket ajouté</div>";
    }
    else{
        return "<div id='connection-state' class='fail'>Erreur inatendue...</div>";
    }


}


$all_dossier = $this->db->query("SELECT noDossier from lesReservations");
$all_dossier = $all_dossier["data"]["NODOSSIER"];

if(isset($_POST["rm"])){
    if($_POST["rm"] !== ""){
        $rep = $this->db->execute("DELETE from LESTICKETS where NOSERIE=".$_POST["rm"]);
        if($rep){
            $this->db->commit();
            echo "<div id='connection-state' class='sucess'>Le ticket à bien été supprimé</div>";
        }
        else{
            echo "<div id='connection-state' class='fail'>Une erreur c'est produite, veuillez réssayer</div>";
        }
    }
}

if(isset($_POST["noSerie"]) and isset($_POST["noSpec"]) and isset($_POST["dateRep"]) and isset($_POST["noPlace"]) and isset($_POST["noRang"]) and isset($_POST["noDossier"])){
    echo add_ticket($this->db);
}

foreach($all_dossier as $dossier){
    echo "<h2>Ticket du dossier numéro $dossier</h2>";
    echo "<div class='reservation'>";
    echo "<form action='' method=POST>";
    echo "<select name=rm>";
    echo "<option value=''>Choissiez un ticket</option>";
    $ticket_asso = $this->db->query("SELECT NOSERIE,DATEREP,NOPLACE from LESTICKETS where NoDossier=$dossier");
    for($i=0;$i<$ticket_asso["number_rows"];$i++){
        echo "<option value=".$ticket_asso["data"]["NOSERIE"][$i].">".$ticket_asso["data"]["NOSERIE"][$i].",".$ticket_asso["data"]["DATEREP"][$i].",".$ticket_asso["data"]["NOPLACE"][$i]."</option>";
    }
    echo "</select>";
    echo "<button type='submit' id='delete'>Supprimer</button></form></div>";
}

?>

<h2>Ajouter un ticket</h2>

<form action="" method=POST>
    <div class="add_form">
        <label>Numéro du ticket</label>
        <input type="text" name="noSerie" value="164" required>
    </div>
    <div class="add_form">
        <label>Numéro du spéctacle</label>
        <input type="text" name="noSpec" value="1" required>
    </div>
    <div class="add_form">
        <label>Date de la représentation</label>
        <input type="date" name="dateRep" value="2017-02-22" min="2016-01-01" max="2020-12-31" required>
    </div>
    <div class="add_form">
        <label>Numéro de la place</label>
        <input type="text" name="noPlace" value="14" required>
    </div>
    <div class="add_form">
        <label>Numéro du rang</label>
        <input type="text" name="noRang" value="1" required>
    </div>
    <div class="add_form">
        <label>numéro du dossier associé</label>
        <input type="text" name="noDossier" value="7" required>
    </div>
    <button type="submit">Ajouter</button>
</form>