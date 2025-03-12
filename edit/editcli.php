<!-- Modal d'édition -->
<?php 
       include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
        $numCompte=$_GET['numCompte'];
       $requete=$connexion->prepare(
        "SELECT * FROM EMPLOYE WHERE numEmp=:numEmp LIMIT 1"
       );
    $requete->bindParam(':numCompte',$numCompte,PDO:: PARAM_INT);
       $requete->execute();
       $resultat=$requete->fetch();
      
        ?>
<div class="modal fade" id="usermodal" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Adding clients</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addform" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <label>Numero compte:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your compte number" autocomplete="off" required="required"
          id="num_compte" name="numCompte">
        </div> 
        <label>name:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your name" autocomplete="off" required="required"
          id="username" name="Nom">
        </div> 
        <label>firstname:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your firstname" autocomplete="off" required="required"
          id="firstname" name="Prenoms">
        </div> 
        <label>tel:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your mobile" autocomplete="off" required="required"
          id="mobile" name="Tel">
        </div> 
        <label>Email:</label>
        <div class="input-group">
          <input type="email" class="form-control center" placeholder="Enter your email" autocomplete="off" required="required"
          id="email" name="mail">
        </div> 
        <label>solde:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your solde" autocomplete="off" required="required"
          id="solde" name="Solde"> <!-- Changement de l'ID ici -->
        </div>                 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-dark" name="submit">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div> 
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
if(isset($_POST['submit'])){
    
    $numCompte=$_GET['numCompte'];
    $numCompte1=$_POST['numCompte'];
    $nom=$_POST['Nom'];
    $prenom=$_POST['Prenoms'];
    $Tel=$_POST['Tel'];
    $mail=$_POST['mail'];
    $Solde=$_POST['Solde'];
    $requete=$connexion->prepare(
        "UPDATE `client` SET `numCompte`='$numCompte1',
        `Nom`='$nom',`Prenom`='$prenom' ,`Tel`='$Tel',`mail`='$mail' ,`Solde`='$Solde'WHERE numCompte=$numCompte"
    );
    $requete->execute();
    if($requete){
        echo"reussie";
    }
    else echo"failed";
    }

?>
