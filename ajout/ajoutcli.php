<div class="modal fade" id="usermodal" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Client</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addform" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <label>Numero compte:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your compte number" autocomplete="off" required="required"
          id="num_compte" name="numCompte">
        </div> 
        <label>nom:</label>
        <div class="input-group">
          <input type="text" class="form-control center" placeholder="Enter your name" autocomplete="off" required="required"
          id="username" name="Nom">
        </div> 
        <label>prénoms:</label>
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
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-dark" name="submit">Soumettre</button>
      </div>
      </form>
    </div>
  </div>
</div> 

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

if(isset($_POST['submit'])){
  // Récupération des valeurs du formulaire
  $numCompte = $_POST['numCompte'];
  $Nom = $_POST['Nom'];
  $Prénoms = $_POST['Prenoms'];
  $Tel = $_POST['Tel'];
  $mail = $_POST['mail'];
  $Solde = $_POST['Solde'];

  // Vérification des valeurs
  if (empty($numCompte) || empty($Nom) || empty($Prénoms) || empty($Tel) || empty($mail) || empty($Solde)) {
      echo "Tous les champs doivent être remplis.";
  } else {
    try {
      // Préparation de la requête SQL
      $requete = $connexion->prepare("INSERT INTO CLIENT (numCompte, Nom, Prenoms, Tel, mail, Solde)
                                       VALUES (:numCompte, :Nom, :Prenoms, :Tel, :mail, :Solde)");

      // Lier les paramètres
      $requete->bindParam(':numCompte', $numCompte);
      $requete->bindParam(':Nom', $Nom);
      $requete->bindParam(':Prenoms', $Prénoms);
      $requete->bindParam(':Tel', $Tel);
      $requete->bindParam(':mail', $mail);
      $requete->bindParam(':Solde', $Solde);

      // Exécution de la requête
      if ($requete->execute()) {
          echo "Le client a été ajouté avec succès.";
      } else {
          echo "Une erreur est survenue lors de l'ajout du client.";
      }
    } catch (PDOException $e) {
      echo "Erreur de base de données : " . $e->getMessage();
    }
  }
}
?>

