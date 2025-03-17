<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>RENDRE</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
        <h1 class="bg-dark text-light text-center py-2">RENDRE</h1>
        <div class="container"></div>
     
        
           <!-- input search and boutton -->
            
        <div class="row mb-3">
           <div class="col-10">
               <div class="input-group">
                    <input type="text" class="form-control center" placeholder="search">
               </div> 
           </div>
           <div class="col-2">
            
            <a href="ajout/ajoutrendre1.php"><button class="btn btn-dark" type="button">TOUT PAYE</button></a>
            <a href="ajout/ajoutrendre2.php"><button class="btn btn-dark" type="button">PAYE A PART</button></a>
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
      <th scope="col">#</th>
    </tr>
  </thead>
 <tbody>
 
     </tbody>
</table>

        </div>
        

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    
        
</body>
    
</html>
