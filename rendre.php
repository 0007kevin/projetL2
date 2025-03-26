<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>RENDRE</title>
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
                        <a class="nav-link" href="pret.php">Pret</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
     
        
           <!-- input search and boutton -->
            
        <div class="row mb-3">
           <div class="col-10">
              
           </div>
           <div class="col-2">
            
            <a href="ajout/ajoutrendre1.php"><button class="btn btn-dark mt-2" type="button">TOUT PAYE</button></a>
            <a href="ajout/ajoutrendre2.php"><button class="btn btn-dark mt-2" type="button">PAYE A PART</button></a>
           </div>
        </div>
        <!-- table -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<table class="table" id="usertable">
  <thead class="table-dark">
    <tr>
      <th scope="col">Numéro Rendu</th>
      <th scope="col">Numéro du pret</th>
      <th scope="col">Date</th>
      <th scope="col">situation</th>
      <th scope="col">Reste à payer</th>
      <th scope="col">montant rendu</th>
      <th scope="col">#</th>
    </tr>
  </thead>
 <tbody>
 
     

        </div>
        

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    
        
</body>
    
</html>
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
