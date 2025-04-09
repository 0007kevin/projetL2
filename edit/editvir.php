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
    <title>Modification de Virement</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            max-width: 500px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
            border-radius: 8px 8px 0 0 !important;
        }
        .btn-return {
            background-color: #6c757d;
            color: white;
            transition: all 0.3s;
        }
        .btn-return:hover {
            background-color: #5a6268;
            color: white;
            transform: translateY(-2px);
        }
        .btn-submit {
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        .form-control:focus {
            border-color: #495057;
            box-shadow: 0 0 0 0.25rem rgba(73, 80, 87, 0.25);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="form-container">
            <div class="card">
                <div class="card-header text-center py-3">
                    <h2 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Modification de Virement</h2>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="compte_source" class="form-label">Compte Expéditeur</label>
                            <input type="text" class="form-control" name="numCompteEnvoyeur" value="<?php echo htmlspecialchars($numCompteEnvoyeur); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="compte_dest" class="form-label">Compte Bénéficiaire</label>
                            <input type="text" class="form-control" name="numCompteBeneficiaire" value="<?php echo htmlspecialchars($numCompteBeneficiaire); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="montant" class="form-label">Montant (€)</label>
                            <input type="number" step="0.01" class="form-control" name="montant" value="<?php echo htmlspecialchars($montant); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_Transfert" class="form-label">Date de Transfert</label>
                            <input type="date" class="form-control" name="date_Transfert" value="<?php echo htmlspecialchars($dateTransfert); ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-submit" name="submit">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                            </button>
                            <a href="javascript:history.back()" class="btn btn-return">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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