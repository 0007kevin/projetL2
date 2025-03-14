<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;


$sql="DELETE FROM VIREMENT WHERE id=:id";
$requete=$connexion->prepare($sql);
$requete->bindParam('id',$id);
$requete->execute();






// Exemple d'utilisation avec la connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Assurez-vous d'inclure votre fichier de connexion

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $id = isset($_GET['id']) ? $_GET['id'] : null;
    $id=$_POST['id'];
    $numCompte1 = $_POST['numCompteEnvoyeur'];
    $numCompte = $_POST['numCompteBenificiaire'];
    $montant = $_POST['montant'];
    $date_Transfert = $_POST['date_Transfert'];
     
   
}
?> 