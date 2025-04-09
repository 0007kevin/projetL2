<?php
include "database/connect.php";

// Initialisation de la requête SQL
$requete = "SELECT * FROM preter";
$params = [];

// Vérifier si le formulaire a été soumis avec des dates valides
if (isset($_POST['search']) && !empty($_POST['date1']) && !empty($_POST['date2'])) {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];

    // Modifier la requête SQL pour inclure la condition sur les dates
    $requete = "SELECT * FROM preter WHERE datepret BETWEEN :date1 AND :date2";
    $params = [':date1' => $date1, ':date2' => $date2];
}

// Exécuter la requête
$stmt = $connexion->prepare($requete);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Prêts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .search-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 20px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,0.02);
        }
        .action-btn {
            transition: transform 0.2s;
        }
        .action-btn:hover {
            transform: scale(1.2);
        }
        .amount-cell {
            font-weight: 500;
        }
        .btn-dark-custom {
            background-color: #212529;
            transition: all 0.3s;
        }
        .btn-dark-custom:hover {
            background-color: #343a40;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hand-holding-usd me-2"></i>GESTION DES PRÊTS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="bank.php">
                            <i class="fas fa-home me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="client.php">
                            <i class="fas fa-users me-1"></i> Clients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="virement.php">
                            <i class="fas fa-exchange-alt me-1"></i> Virements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rendre.php">
                            <i class="fas fa-hand-holding-usd me-1"></i> Remboursements
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container py-4">
        <!-- Formulaire de recherche -->
        <div class="search-container">
            <form method="POST">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="date1" class="form-label">Date de début</label>
                        <input type="date" name="date1" class="form-control" id="date1">
                    </div>
                    <div class="col-md-4">
                        <label for="date2" class="form-label">Date de fin</label>
                        <input type="date" name="date2" class="form-control" id="date2">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" name="search" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Boutons d'action -->
        <div class="d-flex gap-2 mb-4">
            <a href="ajout/ajoutpret.php" class="btn btn-dark">
                <i class="fas fa-plus-circle me-1"></i> Nouveau prêt
            </a>
            <a href="emailpret.php" class="btn btn-dark">
                <i class="fas fa-envelope me-1"></i> Envoyer email
            </a>
        </div>

        <!-- Tableau -->
        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">N° Prêt</th>
                        <th scope="col">N° Compte</th>
                        <th scope="col">Montant prêté</th>
                        <th scope="col">Date du prêt</th>
                        <th scope="col">Date de remboursement</th>
                        <th scope="col">Bénéfice Banque</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($row['num_pret']) ?></th>
                        <td><?= htmlspecialchars($row['numCompte']) ?></td>
                        <td><?= htmlspecialchars($row['montant_prete']) ?></td>
                        <td><?= htmlspecialchars($row['datepret']) ?></td>
                        <td><?= htmlspecialchars($row['date_fin']) ?></td>
                        <td><?= htmlspecialchars($row['beneficeBanque']) ?></td>
                        <td>
                            <a href="edit/editpret.php?num_pret=<?= $row['num_pret']; ?>" class="edit-btn">
                                <i class="fas fa-edit mr-3" title="edit"></i>
                            </a>
                            <a href="delete/deletepret.php?num_pret=<?= $row['num_pret'] ?>" class="link-red" style="color:red;">
                                <i class="fas fa-trash-alt text-danger mr-3" title="delete"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
