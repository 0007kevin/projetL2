<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virement Bancaire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
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
            max-width: 500px;
            position: relative;
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
        <h2>Virement Bancaire</h2>
        
        <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
        
        if (isset($_POST['submit'])) {
            // Récupération des données du formulaire
            $compte_source = $_POST['numCompteEnvoyeur'] ?? null;
            $compte_dest = $_POST['numCompteBeneficiaire'] ?? null;
            $montant = $_POST['montant'] ?? null;
            $date = $_POST['date_Transfert'] ?? null;
        
            // Vérifier que tous les champs sont remplis
            if (!$compte_source || !$compte_dest || !$montant || !$date) {
                echo '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><span>❌ Erreur : Veuillez remplir tous les champs.</span></div>';
            } else {
                try {
                    // Démarrer une transaction pour garantir l'intégrité des données
                    $connexion->beginTransaction();
        
                    // Vérification du solde du compte source (table client)
                    $querySolde = $connexion->prepare("SELECT solde FROM client WHERE numCompte = :numCompteEnvoyeur");
                    $querySolde->bindParam(':numCompteEnvoyeur', $compte_source);
                    $querySolde->execute();
                    $solde_source = $querySolde->fetchColumn();
        
                    if ($solde_source === false) {
                        throw new Exception("❌ Le compte expéditeur n'existe pas.");
                    }
        
                    if ($solde_source < $montant) {
                        throw new Exception("❌ Solde insuffisant sur le compte expéditeur !");
                    }
        
                    // Mettre à jour les soldes des comptes
                    // Débiter le compte expéditeur (table client)
                    $updateSource = $connexion->prepare("UPDATE client SET solde = solde - :montant WHERE numCompte = :numCompteEnvoyeur");
                    $updateSource->bindParam(':montant', $montant);
                    $updateSource->bindParam(':numCompteEnvoyeur', $compte_source);
                    $updateSource->execute();
        
                    // Créditer le compte bénéficiaire (table client)
                    $updateDest = $connexion->prepare("UPDATE client SET solde = solde + :montant WHERE numCompte = :numCompteBeneficiaire");
                    $updateDest->bindParam(':montant', $montant);
                    $updateDest->bindParam(':numCompteBeneficiaire', $compte_dest);
                    $updateDest->execute();
        
                    // Insérer l'opération de virement dans la table 'virement'
                    $insertVirement = $connexion->prepare("INSERT INTO virement (numCompteEnvoyeur, numCompteBeneficiaire, montant, date_Transfert)
                                                            VALUES (:numCompteEnvoyeur, :numCompteBeneficiaire, :montant, :date_Transfert)");
                    $insertVirement->bindParam(':numCompteEnvoyeur', $compte_source);
                    $insertVirement->bindParam(':numCompteBeneficiaire', $compte_dest);
                    $insertVirement->bindParam(':montant', $montant);
                    $insertVirement->bindParam(':date_Transfert', $date);
                    $insertVirement->execute();
        
                    // Valider la transaction (tous les changements sont appliqués)
                    $connexion->commit();
        
                    // Affichage d'un message de succès
                    echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i><span>✅ Le virement a été effectué avec succès.</span></div>';
                } catch (Exception $e) {
                    // En cas d'erreur, annuler la transaction
                    $connexion->rollBack();
                    echo '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><span>❌ Erreur : ' . $e->getMessage() . '</span></div>';
                }
            }
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <label for="compte_source">Compte Expéditeur :</label>
                <input type="text" id="compte_source" name="numCompteEnvoyeur" required>
            </div>

            <div class="form-group">
                <label for="compte_dest">Compte Bénéficiaire :</label>
                <input type="text" id="compte_dest" name="numCompteBeneficiaire" required>
            </div>

            <div class="form-group">
                <label for="montant">Montant (€) :</label>
                <input type="number" id="montant" name="montant" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="date_Transfert">Date Transfert :</label>
                <input type="date" id="date_Transfert" name="date_Transfert" required>
            </div>

            <div class="button-group">
                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-exchange-alt"></i> Effectuer le Virement
                </button>
                <a href="javascript:history.back()" class="btn-return">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>

</body>
</html>