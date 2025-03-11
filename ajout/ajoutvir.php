<div class="modal fade" id="usermodal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">VIREMENT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addform" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <label>Numero compte envoyeur:</label>
          <div class="input-group">
            <input type="text" class="form-control center" placeholder="Enter numCompte" autocomplete="off" required="required"
            id="num_Compte" name="numCompteEnvoyeur">
          </div> 

          <label>Numero compte destinataire:</label>
          <div class="input-group">
            <input type="text" class="form-control center" placeholder="Enter numCompte" autocomplete="off" required="required"
            id="num_Compte" name="numCompteBeneficiaire">
          </div> 

          <label>Montant:</label>
          <div class="input-group">
            <input type="text" class="form-control center" placeholder="Enter montant" autocomplete="off" required="required"
            id="montant" name="montant">
          </div> 

          <label>Date transfert:</label>
          <div class="input-group">
            <input type="date" class="form-control center" autocomplete="off" required="required"
            id="date" name="dateTransfert">
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

if (isset($_POST['submit'])) {
  // Récupération des valeurs du formulaire
  $numCompteDestinataire = $_POST['numCompteBeneficiaire'];  // Utilisation du bon nom de champ
  $numCompteEnvoyeur = $_POST['numCompteEnvoyeur'];          // Utilisation du bon nom de champ
  $montant = $_POST['montant']; 
  $date = $_POST['dateTransfert'];

  // Vérification des valeurs
  if (empty($numCompteDestinataire) || empty($numCompteEnvoyeur) || empty($montant) || empty($date)) {
      echo "Tous les champs doivent être remplis.";
  } else {
    try {
      // Préparation de la requête SQL
      $requete = $connexion->prepare("INSERT INTO VIREMENT (numCompteBeneficiaire, numCompteEnvoyeur, montant, dateTransfert)
                                       VALUES (:numCompteDestinataire, :numCompteEnvoyeur, :montant, :dateTransfert)");

      // Lier les paramètres
      $requete->bindParam(':numCompteDestinataire', $numCompteDestinataire);  // Colonne correcte numCompteBeneficiaire
      $requete->bindParam(':numCompteEnvoyeur', $numCompteEnvoyeur);          // Colonne correcte numCompteEnvoyeur
      $requete->bindParam(':montant', $montant); 
      $requete->bindParam(':dateTransfert', $date);

      // Exécution de la requête
      if ($requete->execute()) {
          echo "Virement effectué avec succès.";
      } else {
          echo "Une erreur est survenue lors du virement.";
      }
    } catch (PDOException $e) {
      echo "Erreur de base de données : " . $e->getMessage();
    }
  }
}
?>
