<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>PRET</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
        <h1 class="bg-dark text-light text-center py-2">PRET</h1>
        <div class="container"></div>
     
        
           <!-- input search and boutton -->
            
        <div class="row mb-3">
           <div class="col-10">
               <div class="input-group">
                    <input type="text" class="form-control center" placeholder="search">
               </div> 
           </div>
           <div class="col-2">
            
            <a href="ajoutpret.php"><button class="btn btn-dark" type="button">NEW PRET</button></a>
           </div>
        </div>
        <!-- table -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<table class="table" id="usertable">
  <thead class="table-dark">
    <tr>
      <th scope="col">Numéro du prêt</th>
      <th scope="col">Numéro de compte</th>
      <th scope="col">Montant prêté</th>
      <th scope="col">Date du prêt</th>
      <th scope="col">#</th>
    </tr>
  </thead>
 <tbody>
  <?php
    include "database/connect.php";
    
      $requete=$connexion->prepare(
        "SELECT * FROM preter");
$requete->execute();
while($row=$requete->fetch()){
  ?>
  <tr>
      <th scope="row"><?php echo $row['num_pret']?></th>
      <th scope="row"><?php echo $row['numCompte']?></th>
      <th scope="row"><?php echo $row['montant_prete']?></th>
      <th scope="row"><?php echo $row['datepret']?></th>
      <th scope="row"><?php echo $row['beneficeBanque']?></th>
     
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
