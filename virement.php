<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>CLIENT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
        <h1 class="bg-dark text-light text-center py-2">VIREMENT</h1>
        <div class="container">
            <!-- form modal -->
            <!-- <div class="modal fade" id="usermodal" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Adding clients</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addform" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
      <label>Numero compte:</label>
                <div class="input-group">
                    <input type="text" class="form-control center" placeholder="Enter your compte number" autocomplete="off" required="required"
                    id="num_compte">
                </div> 
      <label>name:</label>
                <div class="input-group">
                    <input type="text" class="form-control center" placeholder="Enter your name" autocomplete="off" required="required"
                    id="username">
                </div> 
        <label>firstname:</label>
                <div class="input-group">
                    <input type="text" class="form-control center" placeholder="Enter your firstname" autocomplete="off" required="required"
                    id="firstname">
                </div> 
        <label>tel:</label>
                <div class="input-group">
                    <input type="text" class="form-control center" placeholder="Enter your mobile" autocomplete="off" required="required"
                    id="mobile">
                </div> 
        <label>Email:</label>
                <div class="input-group">
                    <input type="email" class="form-control center" placeholder="Enter your email" autocomplete="off" required="required"
                    id="email">
                </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-dark">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>  -->
         <?php include "ajout/ajoutvir.php"?>
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
        <table class="table" id="usertable">
  <thead class="table-dark">
    <tr>
      <th scope="col">numCompte destinataire</th>
      <th scope="col">numCompte envoyeur</th>
      <th scope="col">montant</th>
      <th scope="col">date</th>
      <th scope="col">#</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>
        <span>edit</span>
        <span>delete</span>
      </td>
    </tr>
    
  </tbody>
</table>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    
        
</body>
    
</html>