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
<html>
<head>
    <meta charset="UTF-8">
    <title>Suppression</title>
    <link href="../../css/bootstrap5.3.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if ($requete): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                votre virement a été supprimé avec succès.
                <a href="../virement.php" class="btn btn-sm btn-dark ms-3">Retour </a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Échec de la suppression.
                <a href="../virement.php" class="btn btn-sm btn-danger ms-3">Retour </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>