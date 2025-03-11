<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../css/bootstrap5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
    liste des clients
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
  <th scope="col">Numero Compte</th>
        <th scope="col">name</th>
        <th scope="col">firstname</th>
        <th scope="col">tel</th>
        <th scope="col">email</th>
        <th>#</th>
  </thead>
  <tbody>
   