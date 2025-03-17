<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
// Récupérer l'ID du pret depuis l'URL
$num_pret = $_GET['num_pret'] ?? null;
if ($num_pret) {
    // Récupérer les informations du pret depuis la base de données
    $query = $connexion->prepare("SELECT * FROM preter WHERE num_pret = :num_pret");
    $query->bindParam(':num_pret', $num_pret);
    $query->execute();
    $pret = $query->fetch();

    if ($pret) {
        // Remplir les champs du formulaire avec les données du virement
        $num_pret = $pret['num_pret'];
        $numCompte = $pret['numCompte'];
        $montant = $pret['montant_prete'];
        $datepret = $pret['datepret'];
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Prêt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background: #218838;
        }
        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>

    <form action="" method="POST">
        <h2>Formulaire de Prêt</h2>
        
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <label for="num_pret">Numéro du prêt</label>
        <input type="text" id="numPret" name="num_pret" value="<?php echo $num_pret; ?>" required>

        <label for="numCompte">Numéro de compte</label>
        <input type="text" id="numCompte" name="numCompte"value="<?php echo $numCompte; ?>" required>

        <label for="montant_preté">Montant prêté</label>
        <input type="number" id="montant" name="montant_prete" value="<?php echo $montant; ?>"required>

        <label for="datepret">Date du prêt</label>
        <input type="date" id="datePret" name="datepret" value="<?php echo $datepret; ?>"required>

        <button type="submit" name="submit2">Soumettre</button>
    </form>

</body>
</html>

<?php
  include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
    $num_pret = $_GET['num_pret'] ?? null;
    $numCompte = $_POST['numCompte'] ?? null;
    $montant_prete = $_POST['montant_prete'] ?? "";
    $datepret = $_POST['datepret'] ?? "";
 

    if ($num_pret) { 
        $sql = "UPDATE PRETER SET numCompte = :numCompte, montant_prete = :montant_prete, datepret = :datepret WHERE num_pret = :num_pret";
        
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':numCompte', $numCompte);
        $stmt->bindParam(':montant_prete', $montant_prete);
        $stmt->bindParam(':datepret', $datepret);
        $stmt->bindParam(':num_pret', $num_pret);
        $stmt->execute();
}
}
?>
