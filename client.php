<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>CLIENT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
        <h1 class="bg-dark text-light text-center py-2">CLIENT</h1>
        <div class="container"></div>
     
          <?php include "ajout/ajoutcli.php"?>
          <?php include "delete/deletecli.php"?>
           <!-- input search and boutton -->
            
        <div class="row mb-3">
           <div class="col-10">
               <div class="input-group">
                    <input type="text" class="form-control center" placeholder="search">
               </div> 
           </div>
           <div class="col-2">
            <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#usermodal">
                 ADD NEW
            </button>
           </div>
        </div>
        <!-- table -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<table class="table" id="usertable">
  <thead class="table-dark">
    <tr>
      <th scope="col">num client</th>
      <th scope="col">nom</th>
      <th scope="col">prenoms</th>
      <th scope="col">tel</th>
      <th scope="col">email</th>
      <th scope="col">solde</th>
      <th scope="col">#</th>
    </tr>
  </thead>
 <tbody>
  <?php
    include "database/connect.php";
      $requete=$connexion->prepare(
        "SELECT * FROM client");
$requete->execute();
while($row=$requete->fetch()){
  ?>
  <tr>
      <th scope="row"><?php echo $row['numCompte']?></th>
      <th scope="row"><?php echo $row['Nom']?></th>
      <th scope="row"><?php echo $row['Prenoms']?></th>
      <th scope="row"><?php echo $row['Tel']?></th>
      <th scope="row"><?php echo $row['mail']?></th>
      <th scope="row"><?php echo $row['Solde']?></th>
      <td>
      <a href="#" class="edit-btn" 
   data-numcompte="<?php echo $row['numCompte']; ?>"
   data-nom="<?php echo $row['Nom']; ?>"
   data-prenoms="<?php echo $row['Prenoms']; ?>"
   data-tel="<?php echo $row['Tel']; ?>"
   data-mail="<?php echo $row['mail']; ?>"
   data-solde="<?php echo $row['Solde']; ?>"
   data-bs-toggle="modal" data-bs-target="#editModal">
   <i class="fas fa-edit  mr-3" title="edit"></i>
</a>
 
       <a href="delete/deletecli.php?numCompte=<?php echo $row['numCompte']?>" class="link-red " style="color:red;">
       <i class="fas fa-trash-alt text-danger mr-3" title="delete"></i> </a>
    </td>
    
    </tr>
   
    <?php
     }
     ?>
     </tbody>
</table>

        </div>
        <?php include "edit/editcli.php"?>

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    
        
</body>
    
</html>