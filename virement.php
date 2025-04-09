<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Virements</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .action-container {
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
            margin: 0 5px;
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
        .pdf-btn {
            color: #d63384;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-exchange-alt me-2"></i>GESTION DES VIREMENTS
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
                        <a class="nav-link" href="pret.php">
                            <i class="fas fa-hand-holding me-1"></i> Prêts
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
        <!-- Bouton d'action -->
        <div class="action-container d-flex justify-content-end">
            <a href="ajout/ajoutvir.php" class="btn btn-dark">
                <i class="fas fa-plus-circle me-1"></i> Nouveau virement
            </a>
        </div>

        <!-- Tableau -->
        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Compte expéditeur</th>
                        <th scope="col">Compte bénéficiaire</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Date de transfert</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
 <tbody>
  <?php
    include "database/connect.php";
    
      $requete=$connexion->prepare(
        "SELECT * FROM virement");
$requete->execute();
while($row=$requete->fetch()){
  ?>
  <tr>
      <th scope="row"><?php echo $row['numCompteEnvoyeur']?></th>
      <th scope="row"><?php echo $row['numCompteBeneficiaire']?></th>
      <th scope="row"><?php echo $row['montant']?></th>
      <th scope="row"><?php echo $row['date_Transfert']?></th>
     
      <td>
 
      <a href="edit/editvir.php?id=<?php echo $row['id']; ?>" class="edit-btn">
<i class="fas fa-edit mr-3" title="edit"></i>
</a>

 
       
   <a href="delete/deletevir.php?id=<?php echo $row['id']?>" class="link-red " style="color:red;">
   <i class="fas fa-trash-alt text-danger mr-3" title="delete"></i> </a>

   <a href="pdf.php" class="link-green " style="color:green;">
   <i class="fas fa-file-pdf" title="avis virement"></i></a>
    </td>
    
    </tr>
   
    <?php
     }
     ?>
     </tbody>
</table>

        </div>
        

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    
        
</body>
    
</html>