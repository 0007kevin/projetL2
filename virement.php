<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>VIREMENT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container">
            <a class="navbar-brand" href="#">VIREMENT</a>
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
                    <a class="nav-link" href="pret.php">Pret</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="rendre.php">Remboursements</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <div class="container"></div>
     
        
           <!-- input search and boutton -->
            
        <div class="row mb-3">
           <div class="col-10">
               
           </div>
           <div class="col-2">
            
            <a href="ajout/ajoutvir.php"><button class="btn btn-dark mt-2" type="button">NEW VIREMENT</button></a>
           </div>
        </div>
        <!-- table -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<table class="table" id="usertable">
  <thead class="table-dark">
    <tr>
      <th scope="col">Compte expediteur</th>
      <th scope="col">Compte benificiaire</th>
      <th scope="col">montant</th>
      <th scope="col">date Transfert</th>
      <th scope="col">#</th>
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