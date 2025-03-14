<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Récupérer l'ID du virement depuis l'URL
$id = $_GET['id'] ?? null;
if ($id) {
    // Récupérer les informations du virement depuis la base de données
    $query = $connexion->prepare("SELECT * FROM virement WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $virement = $query->fetch();

    if ($virement) {
        // Remplir les champs du formulaire avec les données du virement
        $numCompteEnvoyeur = $virement['numCompteEnvoyeur'];
        $numCompteBeneficiaire = $virement['numCompteBeneficiaire'];
        $montant = $virement['montant'];
        $dateTransfert = $virement['date_Transfert'];
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virement Bancaire</title>
    <link rel="stylesheet" href="../css/ajoutvir.css">
</head>
<body>
    <div class="container">
        <h2>Virement Bancaire</h2>
        <form method="POST">
            <label for="compte_source">Compte Expéditeur :</label>
            <input type="text" name="numCompteEnvoyeur" value="<?php echo $numCompteEnvoyeur; ?>" required>

            <label for="compte_dest">Compte Bénéficiaire :</label>
            <input type="text" name="numCompteBeneficiaire"  value="<?php echo $numCompteBeneficiaire; ?>" required>

            <label for="montant">Montant (€) :</label>
            <input type="number" name="montant" step="0.01" value="<?php echo $montant; ?>" required>

            <label for="date Transfert">Date Transfert:</label>
            <input type="date" name="date_Transfert"  value="<?php echo $dateTransfert; ?>" required>

            <button type="submit" name="submit">Effectuer le Virement</button>
        </form>
    </div>
</body>
</html>

<?php
  include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = $_GET['id'] ?? null;
    $numCompteEnvoyeur = $_POST['numCompteEnvoyeur'] ?? null;
    $numCompteBeneficiaire = $_POST['numCompteBeneficiaire'] ?? "";
    $montant = $_POST['montant'] ?? "";
    $date = $_POST['date_Transfert'] ?? "";
 

    if ($id) { 
        $sql = "UPDATE VIREMENT SET numCompteEnvoyeur = :numCompteEnvoyeur, numCompteBeneficiaire = :numCompteBeneficiaire, montant = :montant, date_Transfert = :date_Transfert WHERE id = :id";
        
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':numCompteEnvoyeur', $numCompteEnvoyeur);
        $stmt->bindParam(':numCompteBeneficiaire', $numCompteBeneficiaire);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':date_Transfert', $date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
}
}
?>
