<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <li class="nav-item"><a class="nav-link active" href="bank.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="virement.php">Virement</a></li>
                <li class="nav-item"><a class="nav-link" href="pret.php">Prêt</a></li>
                <li class="nav-item"><a class="nav-link" href="rendre.php">Remboursements</a></li>
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
                <input type="text" name="search" class="form-control" placeholder="Rechercher un client"
                    value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
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

    if (isset($_POST['submitted']) && !empty($_POST['search'])) {
        $search = trim($_POST['search']);
        $sql = "SELECT * FROM CLIENT WHERE Nom LIKE :search OR Prenoms LIKE :search OR numCompte LIKE :search";
        $stmt = $connexion->prepare($sql);
        $like_search = "%" . $search . "%";
        $stmt->bindParam(':search', $like_search, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $result = $connexion->query("SELECT * FROM client")->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Numéro compte</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Solde</th>
                <th>Actions</th>
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
                            <button class="edit-btn text-primary " 
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-numcompte="<?= $row['numCompte']; ?>"
                                    data-nom="<?= $row['Nom']; ?>"
                                    data-prenoms="<?= $row['Prenoms']; ?>"
                                    data-tel="<?= $row['Tel']; ?>"
                                    data-mail="<?= $row['mail']; ?>"
                                    data-solde="<?= $row['Solde']; ?>">
                                <i class="fas fa-edit mr-3"></i>
                            </button>
                            <a href="delete/deletecli.php?numCompte=<?php echo $row['numCompte']; ?>" class="text-danger">
                                <i class="fas fa-trash-alt"></i>
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

<script src="js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('.edit-btn').click(function() {
        var numCompte = $(this).data('numcompte');
        var nom = $(this).data('nom');
        var prenoms = $(this).data('prenoms');
        var tel = $(this).data('tel');
        var mail = $(this).data('mail');
        var solde = $(this).data('solde');

        $('#editModal #num_compte').val(numCompte);
        $('#editModal #username').val(nom);
        $('#editModal #firstname').val(prenoms);
        $('#editModal #mobile').val(tel);
        $('#editModal #email').val(mail);
        $('#editModal #solde').val(solde);
    });
});
</script>

</body>
</html>
