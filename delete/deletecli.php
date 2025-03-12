<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
$numCompte=$_GET['numCompte'];
$sql="DELETE FROM CLIENT WHERE numCompte=:numCompte";
$requete=$connexion->prepare($sql);
$requete->bindParam(':numCompte',$numCompte);
$requete->execute();
if($requete){
    header("location: index.php?msg= Deleted successfully");
}
else 
echo "Failed";
?>