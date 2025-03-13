<?php 
        include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
        $numCompte = $_GET['numCompte'] ?? null;
       $requete=$connexion->prepare(
        "SELECT * FROM CLIENT WHERE numCompte=:numCompte LIMIT 1"
       );
    $requete->bindParam(':numCompte',$numCompte,PDO:: PARAM_INT);
       $requete->execute();
       $resultat=$requete->fetch();
      
        ?>
<div class="modal fade" id="editModal" role="dialog" >

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Updating clients</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addform" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <label>Numero compte:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your compte number" autocomplete="off" 
          required="required"
          id="num_compte" name="numCompte"
          value="<?php print_r($resultat['numCompte']);?>">
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
          id="solde" name="Solde"> 
         </div>                 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-dark" name="submit1">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>  

<?php
  include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit1'])) {
    $numCompte = $_POST['numCompte'] ?? null;
    $nom = $_POST['Nom'] ?? "";
    $prenoms = $_POST['Prenoms'] ?? "";
    $tel = $_POST['Tel'] ?? "";
    $mail = $_POST['mail'] ?? "";
    $solde = $_POST['Solde'] ?? "";

    if ($numCompte) { 
        $sql = "UPDATE client SET Nom = :nom, Prenoms = :prenoms, Tel = :tel, mail = :mail, Solde = :solde WHERE numCompte = :numCompte";
        
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenoms', $prenoms);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':solde', $solde);
        $stmt->bindParam(':numCompte', $numCompte);
        $stmt->execute();
}
}
?>

