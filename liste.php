<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<style>
        .search-container {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
        }

        /*  */

        .search-container i {
            background-color: black;
            color: white;
            width: 30px; /* Largeur de l'icône */
            height: 35px; /* Prend toute la hauteur du champ de texte */
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px; /* Arrondir les coins */
            padding: 10px;
            cursor: pointer;
        }
    </style>
<body>
  


<nav class="navbar navbar-dark justify-content-center fs-3 mb-5"style="background-color:orange;">
    Liste des employées en congé
</nav>

<div class="container mt-5">
    <div class="search-container mb-4">
        <!-- Icône de recherche avec fond noir -->
        <i class="fa-solid fa-search mt-2"></i>
        <!-- Champ de saisie de texte -->
        <input type="text" class="form-control mt-2" placeholder="Rechercher...">
    </div>
</div>
<table class="table">
  <thead class="table-dark">
  <th scope="col">Numéro du compte</th>
        <th scope="col">Nom</th>
        <th scope="col">Prenoms</th>
        <th scope="col">Tel</th>
        <th scope="col">mail</th>
        <th scope="col">Solde</th>
        <th>#</th>
  </thead>
  <tbody>
    <?php
    include "../connexiondb/db.php";
      $requete=$connexion->prepare(
        "SELECT * FROM CLIENT");
$requete->execute();
while($row=$requete->fetch()){
  ?>
  <tr>
      <th scope="row"><?php echo $row['numCompte']?></th>
      <th scope="row"><?php echo $row['Nom']?></th>
      <th scope="row"><?php echo $row['Prenoms']?></th>
      <th scope="row"><?php echo $row['Tel']?></th>
      <th scope="row"><?php echo $row['dateDemande']?></th>
      <th scope="row"><?php echo $row['dateRetour']?></th>
      <td>
    <a href="../edit/editConge.php?numEmp=<?php echo $row['numEmp'] ?>" class="link-dark  " style="color:black;"> 
       <i class="fa-solid fa-pen-to-square fs-5 me-3" ></i> </a>
       <a href="../delete/deletecongé.php?numEmp=<?php echo $row['numEmp']?>" class="link-red " style="color:red;">
                           <i class="fa-solid fa-trash fs-5"></i>
                        </a>
    </td>
    
    </tr>
   
    <?php
    }
    ?>
    
  </tbody>
</table>
</div>
</body>
</html>