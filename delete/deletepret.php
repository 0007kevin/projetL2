<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
$num_pret = isset($_GET['num_pret']) ? $_GET['num_pret'] : null;


$sql="DELETE FROM PRETER WHERE num_pret=:num_pret";
$requete=$connexion->prepare($sql);
$requete->bindParam('num_pret',$num_pret);
$requete->execute();






// Exemple d'utilisation avec la connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Assurez-vous d'inclure votre fichier de connexion

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
  $num_pret = isset($_GET['num_pret']) ? $_GET['num_pret'] : null;
    $num_pret=$_POST['num_pret'];
    $numCompte = $_POST['numCompte'];
    $montant_prete = $_POST['montant_prete'];
    $datepret = $_POST['datepret'];
    $datepret = $_POST['date_fin'];
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
                votre pret a été supprimé avec succès.
                <a href="../pret.php" class="btn btn-sm btn-dark ms-3">Retour </a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Échec de la suppression.
                <a href="../pret.php" class="btn btn-sm btn-danger ms-3">Retour </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>