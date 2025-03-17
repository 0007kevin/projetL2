

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
        <input type="text" id="numPret" name="num_pret" required>

        <label for="numCompte">Numéro de compte</label>
        <input type="text" id="numCompte" name="numCompte" required>

        <label for="montant_preté">Montant prêté</label>
        <input type="number" id="montant" name="montant_prete" required>

        <label for="datepret">Date du prêt</label>
        <input type="date" id="datePret" name="datepret" required>

        <button type="submit" name="submit2">Soumettre</button>
    </form>

</body>
</html>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
    // Vérifie si les données sont bien définies dans le formulaire
    $numPret = isset($_POST['num_pret']) ? $_POST['num_pret'] : null;
    $compte_source = isset($_POST['numCompte']) ? $_POST['numCompte'] : null;
    $montant = isset($_POST['montant_prete']) ? $_POST['montant_prete'] : null;
    $date = isset($_POST['datepret']) ? $_POST['datepret'] : null;
    $beneficeBanque=($montant)*0.1;

    // Validation des champs
    if (!$numPret || !$compte_source || !$montant || !$date) {
        $message = "❌ Veuillez remplir tous les champs.";
    } elseif (!is_numeric($montant) || $montant <= 0) {
        $message = "❌ Le montant doit être un nombre positif.";
    } else {
        try {
            // Démarrer la transaction
            $connexion->beginTransaction();

            // Insérer l'opération de prêt
            $insertpreter = $connexion->prepare("INSERT INTO preter (num_pret, numCompte, montant_prete, datepret,beneficeBanque) 
                                                VALUES (:num_pret, :numCompte, :montant_prete, :datepret,:beneficeBanque)");

            if ($insertpreter) {  // Vérifie que la requête a été correctement préparée
                $insertpreter->bindParam(':num_pret', $numPret);
                $insertpreter->bindParam(':numCompte', $compte_source);
                $insertpreter->bindParam(':montant_prete', $montant);
                $insertpreter->bindParam(':datepret', $date);
                $insertpreter->bindParam(':beneficeBanque', $beneficeBanque);

                $insertpreter->execute();
            } else {
                throw new Exception("❌ La requête d'insertion n'a pas pu être préparée.");
            }

            // Vérifier que le compte existe et récupérer son solde
            $querySolde = $connexion->prepare("SELECT solde FROM client WHERE numCompte = :numCompte");
            $querySolde->bindParam(':numCompte', $compte_source);
            $querySolde->execute();
            $solde_source = $querySolde->fetchColumn();

            if ($solde_source === false) {
                throw new Exception("❌ Le compte spécifié n'existe pas.");
            }

            // Mettre à jour le solde du compte emprunteur après insertion
            $updateSolde = $connexion->prepare("UPDATE client SET solde = solde + :montant WHERE numCompte = :numCompte");
            $updateSolde->bindParam(':montant', $montant);
            $updateSolde->bindParam(':numCompte', $compte_source);
            $updateSolde->execute();

            // Valider la transaction si tout a bien fonctionné
            $connexion->commit();
            $message = "✅ Le prêt a été enregistré avec succès.";
        } catch (Exception $e) {
            // Si une erreur survient, annuler la transaction
            $connexion->rollBack();
            $message = "❌ Erreur : " . $e->getMessage();
        }
    }
}
?>
