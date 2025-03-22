<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Récupérer l'ID du pret depuis l'URL
$num_rendu = $_GET['num_rendu'] ?? null;
if ($num_rendu) {
    // Récupérer les informations du pret depuis la base de données
    $query = $connexion->prepare("SELECT * FROM rendre WHERE num_rendu = :num_rendu");
    $query->bindParam(':num_rendu', $num_rendu);
    $query->execute();
    $rendre = $query->fetch();

    if ($rendre) {
        // Remplir les champs du formulaire avec les données du virement
        $num_rendu = $rendre['num_rendu'];
        $num_pret = $rendre['num_pret'];
        $date_rendu = $rendre['date_rendu'];
        $montant_rendu = $rendre['montant_rendu'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendre de l'Argent</title>
    <link rel="stylesheet" href="/projetL2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="bg-dark text-light text-center py-2">Rendre de l'Argent à la Banque</h2>

        <form action="" method="POST" class="border p-4 shadow rounded">
            <div class="mb-3">
                <label for="num_rendu" class="form-label">Numéro de Rendu</label>
                <input type="number" class="form-control" id="num_rendu" name="num_rendu" value="<?php echo $num_rendu; ?>" required>
            </div>

            <div class="mb-3">
                <label for="num_pret" class="form-label">Numéro du Prêt</label>
                <input type="number" class="form-control" id="num_pret" name="num_pret" value="<?php echo $num_pret; ?>"required>
            </div>

            <div class="mb-3">
                <label for="date_rendu" class="form-label">Date de Rendu</label>
                <input type="date" class="form-control" id="date_rendu" name="date_rendu" value="<?php echo $date_rendu; ?>" required>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" class="form-control" id="montant_rendu" name="montant_rendu"value="<?php echo $montant_rendu; ?>" required>
            </div>

            <button type="submit" class="btn btn-dark w-100" name="submit4">Enregistrer le Rendu</button>
        </form>
    </div>

    <script src="/projetL2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
  include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit4'])) {
    $num_rendu = $_GET['num_rendu'] ?? null;
    $num_pret = $_POST['num_pret'] ?? null;
    $date_rendu = $_POST['date_rendu'] ?? "";
    $montant_rendu = $_POST['montant_rendu'] ?? "";
   
 

    if ($num_rendu) { 
        $sql = "UPDATE rendre SET num_pret = :num_pret, date_rendu = :date_rendu ,montant_rendu = :montant_rendu WHERE num_rendu = :num_rendu";
        
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':num_pret', $num_pret);
        $stmt->bindParam(':date_rendu', $date_rendu);
        $stmt->bindParam(':montant_rendu', $montant_rendu);
        $stmt->bindParam(':num_rendu', $num_rendu);
        $stmt->execute();
}
}
?>