<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Remboursements</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .action-buttons {
            margin-bottom: 20px;
        }
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 20px;
            margin-top: 20px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .status-paid {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .status-partial {
            background-color: #fff3cd;
            color: #664d03;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,0.02);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hand-holding-usd me-2"></i>GESTION DES REMBOURSEMENTS
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
                        <a class="nav-link" href="pret.php">
                            <i class="fas fa-hand-holding me-1"></i> Prêts
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container py-4">
        <!-- Boutons d'action -->
        <div class="action-buttons d-flex gap-2 mb-4">
            <a href="ajout/ajoutrendre1.php" class="btn btn-dark">
                <i class="fas fa-check-circle me-1"></i> Tout payé
            </a>
            <a href="ajout/ajoutrendre2.php" class="btn btn-dark">
                <i class="fas fa-check-double me-1"></i> Payé partiellement
            </a>
            <a href="email.php" class="btn btn-dark">
                <i class="fas fa-envelope me-1"></i> Email
            </a>
        </div>

        <!-- Tableau -->
        <div class="table-container">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">N° Remboursement</th>
                        <th scope="col">N° Prêt</th>
                        <th scope="col">Date</th>
                        <th scope="col">Situation</th>
                        <th scope="col">Reste à payer</th>
                        <th scope="col">Montant remboursé</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <?php
    include "database/connect.php";
    
      $requete=$connexion->prepare(
        "SELECT * FROM rendre");
$requete->execute();
while($row=$requete->fetch()){
  ?>
  <tr>
      <th scope="row"><?php echo $row['num_rendu']?></th>
      <th scope="row"><?php echo $row['num_pret']?></th>
      <th scope="row"><?php echo $row['date_rendu']?></th>
      <th scope="row"><?php echo $row['situation']?></th>
      <th scope="row"><?php echo $row['rest_paye']?></th>
      <th scope="row"><?php echo $row['montant_rendu']?></th>
     
      <td>
 
      <a href="edit/editrendre.php?num_rendu=<?php echo $row['num_rendu']; ?>" class="edit-btn">
<i class="fas fa-edit mr-3" title="edit"></i>
</a>
       
   
<a href="delete/deleterendre.php?num_rendu=<?php echo $row['num_rendu']?>" class="link-red " style="color:red;">
<i class="fas fa-trash-alt text-danger mr-3" title="delete"></i> </a>
    </td>
    
    </tr>
   
    <?php
     }
     ?>
     </tbody>
     </table>
    </html>

