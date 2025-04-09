<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Récupérer l'ID du pret depuis l'URL
$num_pret = $_GET['num_pret'] ?? null;
if ($num_pret) {
    // Récupérer les informations du pret depuis la base de données
    $query = $connexion->prepare("SELECT * FROM preter WHERE num_pret = :num_pret");
    $query->bindParam(':num_pret', $num_pret);
    $query->execute();
    $pret = $query->fetch();

    if ($pret) {
        // Remplir les champs du formulaire avec les données du virement
        $num_pret = $pret['num_pret'];
        $numCompte = $pret['numCompte'];
        $montant = $pret['montant_prete'];
        $datepret = $pret['datepret'];
        $datefin = $pret['date_fin'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de Prêt</title>
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
                    <h2 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Modification de Prêt</h2>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="num_pret" class="form-label">Numéro du prêt</label>
                            <input type="text" class="form-control" id="numPret" name="num_pret" value="<?php echo htmlspecialchars($num_pret); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="numCompte" class="form-label">Numéro de compte</label>
                            <input type="text" class="form-control" id="numCompte" name="numCompte" value="<?php echo htmlspecialchars($numCompte); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="montant_prete" class="form-label">Montant prêté (€)</label>
                            <input type="number" step="0.01" class="form-control" id="montant" name="montant_prete" value="<?php echo htmlspecialchars($montant); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="datepret" class="form-label">Date du prêt</label>
                            <input type="date" class="form-control" id="datePret" name="datepret" value="<?php echo htmlspecialchars($datepret); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de remboursement</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin" value="<?php echo htmlspecialchars($datefin); ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-submit" name="submit2">
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
    $num_pret = $_GET['num_pret'] ?? null;
    $numCompte = $_POST['numCompte'] ?? null;
    $montant_prete = $_POST['montant_prete'] ?? "";
    $datepret = $_POST['datepret'] ?? "";
    $datefin = $_POST['date_fin'] ?? "";
 
    if ($num_pret) { 
        $sql = "UPDATE PRETER SET numCompte = :numCompte, montant_prete = :montant_prete, datepret = :datepret, date_fin = :date_fin WHERE num_pret = :num_pret";
        
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':numCompte', $numCompte);
        $stmt->bindParam(':montant_prete', $montant_prete);
        $stmt->bindParam(':datepret', $datepret);
        $stmt->bindParam(':date_fin', $datefin);
        $stmt->bindParam(':num_pret', $num_pret);

        $stmt->execute();
    }
}
?>