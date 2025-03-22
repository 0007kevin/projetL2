<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
$num_rendu = isset($_GET['num_rendu']) ? $_GET['num_rendu'] : null;


$sql="DELETE FROM rendre WHERE num_rendu=:num_rendu";
$requete=$connexion->prepare($sql);
$requete->bindParam('num_rendu',$num_rendu);
$requete->execute();






// Exemple d'utilisation avec la connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Assurez-vous d'inclure votre fichier de connexion

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit4'])) {
  $num_rendu = isset($_GET['num_rendu']) ? $_GET['num_rendu'] : null;
    $num_rendu=$_POST['num_rendu'];
    $num_pret = $_POST['num_pret'];
    $date_rendu = $_POST['date_rendu'];
    $montant_rendu = $_POST['montant_rendu'];
   
    $beneficeBanque = $_POST['beneficeBanque'];
     
   
}
?> 