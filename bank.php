<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="bank.css">
    
</head>
<script type="text/javascript" src="bank.js" defer ></script>
<body>
    <nav id="sidebar">
        <button onclick="togglesidebar(this)" class="dropdown-btn">
            <i class="fas fa-bars"></i><span>Accueil</span>
        </button>
        <a href="#">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>

        <button onclick="togglesubMenu(this)" class="dropdown-btn">
            <i class="fas fa-user"></i><span>CLIENT</span><i class=" fas fa-chevron-down"></i>
        </button>
        <ul class="sub-menu">
            <div>
                <li><a href="client.php">Liste</a></li>
            </div>
        </ul>

        <button onclick="togglesubMenu(this)" class="dropdown-btn">
            <i class="fas fa-calendar-times"></i><span>VIREMENT</span><i class=" fas fa-chevron-down"></i>
        </button>
        <ul class="sub-menu">
            <div>
                <li><a href="virement.php">Liste</a></li>
            </div>
        </ul>
           
        <button onclick="togglesubMenu(this)" class="dropdown-btn">
            <i class="fas fa-clock"></i><span>PRET</span><i class=" fas fa-chevron-down"></i>
        </button>
        <ul class="sub-menu">
            <div>
                <li><a href="pret.php">Liste</a></li>
            </div>
        </ul>
        <button onclick="togglesubMenu(this)" class="dropdown-btn">
            <i class="fas fa-credit-card"></i><span>REMBOURSEMENT</span><i class=" fas fa-chevron-down"></i>
        </button>
        <ul class="sub-menu">
            <div>
                <li><a href="rendre.php">Liste</a></li>
            </div>
        </ul>
    </nav>

    
       <div style="background-color:#11121a">
     
       </div>
    
       <script src="js/jquery.js"></script>
       <script src="js/bootstrap.min.js"></script>
</body>

</html>