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
    <title>Modification Remboursement</title>
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
            max-width: 600px;
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
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="form-container">
            <div class="card">
                <div class="card-header text-center py-3">
                    <h2 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Modifier Remboursement</h2>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="num_rendu" class="form-label">Numéro de Remboursement</label>
                            <input type="number" class="form-control" id="num_rendu" name="num_rendu" value="<?php echo htmlspecialchars($num_rendu); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="num_pret" class="form-label">Numéro du Prêt</label>
                            <input type="number" class="form-control" id="num_pret" name="num_pret" value="<?php echo htmlspecialchars($num_pret); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_rendu" class="form-label">Date de Remboursement</label>
                            <input type="date" class="form-control" id="date_rendu" name="date_rendu" value="<?php echo htmlspecialchars($date_rendu); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="montant_rendu" class="form-label">Montant (€)</label>
                            <input type="number" step="0.01" class="form-control" id="montant_rendu" name="montant_rendu" value="<?php echo htmlspecialchars($montant_rendu); ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-submit" name="submit4">
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit4'])) {
    $num_rendu = $_GET['num_rendu'] ?? null;
    $num_pret = $_POST['num_pret'] ?? null;
    $date_rendu = $_POST['date_rendu'] ?? "";
    $montant_rendu = $_POST['montant_rendu'] ?? "";
   
    if ($num_rendu) { 
        $sql = "UPDATE rendre SET num_pret = :num_pret, date_rendu = :date_rendu, montant_rendu = :montant_rendu WHERE num_rendu = :num_rendu";
        
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':num_pret', $num_pret);
        $stmt->bindParam(':date_rendu', $date_rendu);
        $stmt->bindParam(':montant_rendu', $montant_rendu);
        $stmt->bindParam(':num_rendu', $num_rendu);
        $stmt->execute();
    }
}
?>