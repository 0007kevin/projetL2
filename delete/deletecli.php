<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
$numCompte = isset($_GET['numCompte']) ? $_GET['numCompte'] : null;

echo ($numCompte);
$sql="DELETE FROM CLIENT WHERE numCompte=:numCompte";
$requete=$connexion->prepare($sql);
$requete->bindParam(':numCompte',$numCompte);
$requete->execute();






// Exemple d'utilisation avec la connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Assurez-vous d'inclure votre fichier de connexion

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $numCompte = isset($_GET['numCompte']) ? $_GET['numCompte'] : null;
    echo($numCompte);
    $numCompte1=$_POST['numCompte'];
    $nom = $_POST['Nom'];
    $prenoms = $_POST['Prenoms'];
    $tel = $_POST['Tel'];
    $mail = $_POST['mail'];
    $solde = $_POST['Solde'];
     
   
}
?> 
