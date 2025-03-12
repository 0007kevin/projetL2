<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/bootstrap5.3.2/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<?php 
       include "../connexiondb/db.php";
        $numEmp=$_GET['numEmp'];
       $requete=$connexion->prepare(
        "SELECT * FROM CONGE WHERE numEmp=:numEmp LIMIT 1"
       );
    $requete->bindParam(':numEmp',$numEmp,PDO:: PARAM_INT);
       $requete->execute();
       $resultat=$requete->fetch();
      
        ?>
<body>
     <nav class="navbar navbar-dark justify-content-center fs-3 mb-5"style="background-color:orange;">
        Gestion de pointage et congé de personnel
</nav>
  <div class="container">
    <div class="text-center mb-4">
          Enter a new information
          <p>click save after completed all things below</p>
    </div>
    <div class="d-flex justify-content-center">
    <form action="" method="post" style="width:50vw; min-width:700px; margin: auto;">
        <div class="row mb-3">
            <div class="col">
                <label for="numConge" class="form-label">Numéro de congé :</label>
                <input type="text" class="form-control" id="numConge" name="numConge" placeholder="Numéro de congé" 
                value ="<?php print_r($resultat['numConge']);?>"required>
            </div>
            <!-- <div class="col">
                <label for="numEmp" class="form-label">Numéro d'employé :</label>
                <input type="text" class="form-control" id="numEmp" name="numEmp" placeholder="Numéro d'employé" required>
            </div> -->
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="motif" class="form-label">Motif :</label>
                <input type="text" class="form-control" id="motif" name="motif" placeholder="Maladie, Vacances, etc." 
                 value ="<?php print_r($resultat['motif']);?>"required>
            </div>
            <div class="col">
                <label for="nbrjr" class="form-label">Nombre de jours :</label>
                <input type="number" class="form-control" id="nbrjr" name="nbrjr" placeholder="Nombre de jours" 
                value ="<?php print_r($resultat['nbrjr']);?>"required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="dateDemande" class="form-label">Date de demande :</label>
                <input type="date" class="form-control" id="dateDemande" name="dateDemande"
                value ="<?php print_r($resultat['dateDemande']);?>" required>
            </div>
            <div class="col">
                <label for="dateRetour" class="form-label">Date de retour :</label>
                <input type="date" class="form-control" id="dateRetour" name="dateRetour" 
                value ="<?php print_r($resultat['dateRetour']);?>"required>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary" name="submit">Soumettre</button>
            <a href="../index.php" class="btn btn-danger ms-4">Annuler</a>
        </div>
    </form>
    </div>
  </div>
</body>
</html>
<?php
include "../connexiondb/db.php";
if(isset($_POST['submit'])){
    
    $numEmp=$_GET['numEmp'];
    echo $numEmp;
    $numConge=$_POST['numConge'];it
    $motif=$_POST['motif'];
    $nbrjr=$_POST['nbrjr'];
    $dateDemande=$_POST['dateDemande'];
    $dateRetour=$_POST['dateRetour'];
    $requete=$connexion->prepare(
        "UPDATE `CONGE` SET `numConge`='$numConge',
        `motif`='$motif',`nbrjr`='$nbrjr',`dateDemande`='$dateDemande' ,`dateRetour`='$dateRetour' WHERE numEmp=$numEmp"
    );
    $requete->execute();
    if($requete){
        echo"reussie";
    }
    else echo"failed";
    }

?>