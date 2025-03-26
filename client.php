<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container">
            <a class="navbar-brand" href="#">CLIENT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="bank.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="virement.php">virement</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="pret.php">Pret</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rendre.php">Remboursements</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php include "ajout/ajoutcli.php"; ?>
        <?php include "delete/deletecli.php"; ?>
        <div class="row mb-3 mt-2">
            <div class="col-10">
                <form method="POST" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un client" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                    <button type="submit" name="submitted" class="btn btn-dark ms-2">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-2">
                <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#usermodal">Ajouter</button>
            </div>
        </div>

        <?php
        include "database/connect.php";

        if (!$connexion) {
            die("Erreur de connexion à la base de données.");
        }

        // Vérification si une recherche est effectuée
        if (isset($_POST['submitted']) && !empty($_POST['search'])) {
            $search = trim($_POST['search']);
            $sql = "SELECT * FROM CLIENT WHERE Nom LIKE :search OR Prenoms LIKE :search OR numCompte LIKE :search";
            $stmt = $connexion->prepare($sql);
            $like_search = "%" . $search . "%";
            $stmt->bindParam(':search', $like_search, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Affichage par défaut de tous les clients
            $result = $connexion->query("SELECT * FROM client")->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>

        <!-- Table des clients -->
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Numéro client</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénoms</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Solde</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['numCompte']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nom']); ?></td>
                            <td><?php echo htmlspecialchars($row['Prenoms']); ?></td>
                            <td><?php echo htmlspecialchars($row['Tel']); ?></td>
                            <td><?php echo htmlspecialchars($row['mail']); ?></td>
                            <td><?php echo htmlspecialchars($row['Solde']); ?> €</td>
                            <td>
                                <a href="#" class="edit-btn" 
                                   data-numcompte="<?php echo $row['numCompte']; ?>"
                                   data-nom="<?php echo $row['Nom']; ?>"
                                   data-prenoms="<?php echo $row['Prenoms']; ?>"
                                   data-tel="<?php echo $row['Tel']; ?>"
                                   data-mail="<?php echo $row['mail']; ?>"
                                   data-solde="<?php echo $row['Solde']; ?>"
                                   data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                </a>

                                <a href="delete/deletecli.php?numCompte=<?php echo $row['numCompte']; ?>" class="text-danger">
                                    <i class="fas fa-trash-alt" title="Supprimer"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun client trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php include "edit/editcli.php"; ?>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
