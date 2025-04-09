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
                votre remboursement a été supprimé avec succès.
                <a href="../rendre.php" class="btn btn-sm btn-dark ms-3">Retour </a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Échec de la suppression.
                <a href="../rendre.php" class="btn btn-sm btn-danger ms-3">Retour </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>