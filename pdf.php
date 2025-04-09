<?php
// Démarrer la session pour afficher les erreurs après redirection
session_start();
require('fpdf186/fpdf186/fpdf.php');
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['account'])) {
    $accountNumber = trim($_POST['account']);

    // Vérifier la connexion à la base de données
    if (!isset($connexion)) {
        $_SESSION['error'] = "Erreur : Connexion à la base de données introuvable.";
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

    try {
        // Récupérer les informations du dernier virement du compte sélectionné
        $query = "
            SELECT 
                v.id AS virement_id, 
                v.numCompteEnvoyeur AS compte_envoyeur,
                v.numCompteBeneficiaire AS compte_beneficiaire,
                v.montant,
                v.date_Transfert,
                c1.Nom AS nom_envoyeur,
                c1.Prenoms AS prenoms_envoyeur,
                c2.Nom AS nom_beneficiaire,
                c2.Prenoms AS prenoms_beneficiaire
            FROM VIREMENT v
            JOIN CLIENT c1 ON v.numCompteEnvoyeur = c1.numCompte
            JOIN CLIENT c2 ON v.numCompteBeneficiaire = c2.numCompte
            WHERE v.numCompteEnvoyeur = :account OR v.numCompteBeneficiaire = :account
            ORDER BY v.date_Transfert DESC
            LIMIT 1
        ";

        $stmt = $connexion->prepare($query);
        $stmt->bindValue(':account', $accountNumber, PDO::PARAM_STR);
        $stmt->execute();
        $virement = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$virement) {
            $_SESSION['error'] = "Aucun virement trouvé pour ce numéro de compte.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        // Récupérer le solde actuel du compte
        $soldeQuery = "SELECT solde FROM CLIENT WHERE numCompte = :account";
        $soldeStmt = $connexion->prepare($soldeQuery);
        $soldeStmt->bindValue(':account', $accountNumber, PDO::PARAM_STR);
        $soldeStmt->execute();
        $soldeResult = $soldeStmt->fetch(PDO::FETCH_ASSOC);
        $solde = $soldeResult ? $soldeResult['solde'] : false;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur SQL : " . $e->getMessage();
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

    // Génération du PDF
    try {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);

        // Encodage UTF-8 pour les caractères spéciaux
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode('MyBanque'), 0, 1, 'C');

        // Date
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode("Date : " . date('d/m/Y')), 0, 1, 'C');
        $pdf->Ln(5);

        // Titre du document
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode("AVIS DE VIREMENT N°" . str_pad($virement['virement_id'], 3, '0', STR_PAD_LEFT)), 0, 1, 'C');
        $pdf->Ln(10);

        // Informations de l'envoyeur
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 7, utf8_decode("N° de compte : " . $virement['compte_envoyeur']), 0, 1);
        $pdf->Cell(0, 7, utf8_decode(strtoupper($virement['nom_envoyeur']) . ' ' . $virement['prenoms_envoyeur']), 0, 1);
        $pdf->Ln(5);

        // Flèche centrée
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, utf8_decode('A'), 0, 1, 'C');
        $pdf->Ln(5);

        // Informations du bénéficiaire
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 7, utf8_decode("N° de compte : " . $virement['compte_beneficiaire']), 0, 1);
        $pdf->Cell(0, 7, utf8_decode(strtoupper($virement['nom_beneficiaire']) . ' ' . $virement['prenoms_beneficiaire']), 0, 1);
        $pdf->Ln(10);

        // Montant
        $pdf->SetFont('Arial', 'B', 14);
        $montant = number_format($virement['montant'], 0, ',', '.');
        $pdf->Cell(0, 10, utf8_decode("Montant viré : $montant Ar"), 0, 1, 'C');

        // Solde actuel (si disponible)
        if ($solde !== false) {
            $pdf->SetFont('Arial', 'B', 12);
            $soldeFormatted = number_format($solde, 0, ',', '.');
            $pdf->Cell(0, 10, utf8_decode("Reste du solde actuel : $soldeFormatted Ar"), 0, 1, 'C');
        }

        // Empêcher la mise en cache
        if (ob_get_length()) {
            ob_end_clean();
        }
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Envoi du PDF avec un nom unique
        $pdf->Output('D', 'avis_virement_' . $accountNumber . '_' . time() . '.pdf');
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur PDF : " . $e->getMessage();
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Génération Avis de Virement</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --error-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        
        .card-header h2 {
            margin: 0;
            font-weight: 600;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .input-field {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s ease;
            box-sizing: border-box;
        }
        
        .input-field:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .btn {
            display: inline-block;
            background-color: var(--secondary-color);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-return {
            background-color: var(--light-color);
            color: var(--dark-color);
        }
        
        .btn-return:hover {
            background-color: #d5dbdb;
        }
        
        .error {
            color: var(--error-color);
            background-color: rgba(231, 76, 60, 0.1);
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid var(--error-color);
            display: none;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo img {
            height: 50px;
        }
        
        .button-group {
            display: flex;
            flex-direction: column;
        }
        
        @media (max-width: 768px) {
            .card {
                max-width: 100%;
            }
            
            .card-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Générer un avis de virement</h2>
            </div>
            <div class="card-body">
                <div class="logo">
                    <!-- Ajoutez votre logo ici -->
                    <!-- <img src="logo.png" alt="Logo Banque"> -->
                </div>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error" style="display: block;">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label for="account">Compte Expéditeur</label>
                        <input type="text" id="account" name="account" class="input-field" required placeholder="Ex:123">
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="btn">
                            <i class="fas fa-file-pdf"></i> Générer PDF
                        </button>
                        <a href="javascript:history.back()" class="btn btn-return">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>