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



function updateClient($conn, $numCompte, $nom, $prenoms, $tel, $mail, $solde) {
    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // if(!empty($data)){
    //   $fields="";
    //   $x=1;
    //   $fieldsCount=count($data);
    //   foreach ($data as $field => $value) {
    //     $fields.="{$field}=:{$field}";
    //   }
    // }
    
    // Requête SQL pour mettre à jour les informations du client
    $sql = "UPDATE clients SET Nom=?, Prenoms=?, Tel=?, mail=?, Solde=? WHERE numCompte=?";
    
    // Préparation de la requête
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssi", $nom, $prenoms, $tel, $mail, $solde, $numCompte);
        
        // Exécution de la requête
        if ($stmt->execute()) {
            echo "Client updated successfully.";
        } else {
            echo "Error updating client: " . $stmt->error;
        }
        
        // Fermeture de la requête
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Exemple d'utilisation avec la connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Assurez-vous d'inclure votre fichier de connexion

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $numCompte = $_POST['numCompte'];
    $nom = $_POST['Nom'];
    $prenoms = $_POST['Prenoms'];
    $tel = $_POST['Tel'];
    $mail = $_POST['mail'];
    $solde = $_POST['Solde'];
    
    updateClient($conn, $numCompte, $nom, $prenoms, $tel, $mail, $solde);
}
?>
