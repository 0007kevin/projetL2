<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Prêt</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --gray-color: #95a5a6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
        }
        
        h2 {
            text-align: center;
            color: var(--dark-color);
            margin-bottom: 25px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
            color: var(--dark-color);
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--secondary-color);
            color: white;
            font-size: 16px;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-submit:hover {
            background: #27ae60;
        }
        
        .btn-return {
            width: 100%;
            padding: 12px;
            background: var(--light-color);
            color: var(--dark-color);
            font-size: 16px;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            text-align: center;
        }
        
        .btn-return:hover {
            background: #d5dbdb;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: rgba(46, 204, 113, 0.2);
            border-left: 4px solid var(--secondary-color);
            color: var(--secondary-color);
        }
        
        .alert-error {
            background-color: rgba(231, 76, 60, 0.2);
            border-left: 4px solid var(--danger-color);
            color: var(--danger-color);
        }
        
        .button-group {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }
        
        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Formulaire de Prêt</h2>
        
        <?php 
        if (!empty($message)): 
            $alertClass = strpos($message, '✅') !== false ? 'alert-success' : 'alert-error';
            $iconClass = strpos($message, '✅') !== false ? 'fa-check-circle' : 'fa-exclamation-circle';
        ?>
            <div class="alert <?php echo $alertClass; ?>">
                <i class="fas <?php echo $iconClass; ?>"></i>
                <span><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="num_pret">Numéro du prêt</label>
                <input type="text" id="numPret" name="num_pret" required>
            </div>

            <div class="form-group">
                <label for="numCompte">Numéro de compte</label>
                <input type="text" id="numCompte" name="numCompte" required>
            </div>

            <div class="form-group">
                <label for="montant_preté">Montant prêté</label>
                <input type="number" id="montant" name="montant_prete" required>
            </div>

            <div class="form-group">
                <label for="datepret">Date du prêt</label>
                <input type="date" id="datePret" name="datepret" required>
            </div>

            <div class="form-group">
                <label for="datepret">Date de remboursement</label>
                <input type="date" id="date_fin" name="date_fin" required>
            </div>

            <div class="button-group">
                <button type="submit" name="submit2" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Soumettre
                </button>
                <a href="javascript:history.back()" class="btn-return">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>

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
    $datefin = isset($_POST['date_fin']) ? $_POST['date_fin'] : null;
    $beneficeBanque=($montant)*0.1;

    // Validation des champs
    if (!$numPret || !$compte_source || !$montant || !$date || !$datefin) {
        $message = "❌ Veuillez remplir tous les champs.";
    } elseif (!is_numeric($montant) || $montant <= 0) {
        $message = "❌ Le montant doit être un nombre positif.";
    } else {
        try {
            // Démarrer la transaction
            $connexion->beginTransaction();

            // Insérer l'opération de prêt
            $insertpreter = $connexion->prepare("INSERT INTO preter (num_pret, numCompte, montant_prete, datepret,date_fin, beneficeBanque) 
                                                VALUES (:num_pret, :numCompte, :montant_prete, :datepret,:date_fin ,:beneficeBanque)");

            if ($insertpreter) {  // Vérifie que la requête a été correctement préparée
                $insertpreter->bindParam(':num_pret', $numPret);
                $insertpreter->bindParam(':numCompte', $compte_source);
                $insertpreter->bindParam(':montant_prete', $montant);
                $insertpreter->bindParam(':datepret', $date);
                $insertpreter->bindParam(':date_fin', $datefin);
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
