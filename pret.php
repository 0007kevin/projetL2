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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRET</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container">
            <a class="navbar-brand" href="#">PRET</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="bank.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="client.php">client</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="virement.php">virement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rendre.php">Remboursements</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row mb-3">
            <div class="col-10">
                <form method="POST">
                    <div class="search-container mb-4">
                        <div class="row">
                            <div class="col">
                                <input type="date" name="date1" class="form-control mt-2" placeholder="Date 1">
                            </div>
                            <div class="col">
                                <input type="date" name="date2" class="form-control mt-2" placeholder="Date 2">
                            </div>
                            <div class="col">
                                <button type="submit" name="search" class="btn btn-primary mt-2">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2">
                <a href="ajout/ajoutpret.php"><button class="btn btn-dark mt-2" type="button">NEW PRET</button></a>
            </div>
        </div>

        <!-- Table -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <table class="table" id="usertable">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Numéro du prêt</th>
                    <th scope="col">Numéro de compte</th>
                    <th scope="col">Montant prêté</th>
                    <th scope="col">Date du prêt</th>
                    <th scope="col">Bénéfice Banque</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($row['num_pret']) ?></th>
                        <td><?= htmlspecialchars($row['numCompte']) ?></td>
                        <td><?= htmlspecialchars($row['montant_prete']) ?></td>
                        <td><?= htmlspecialchars($row['datepret']) ?></td>
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
