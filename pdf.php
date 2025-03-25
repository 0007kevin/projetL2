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
    <title>Génération Avis de Virement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        .search-box {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }
        input[type="text"] {
            padding: 8px;
            width: 200px;
            margin-right: 10px;
        }
        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="search-box">
        <h2>Générer un avis de virement</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form method="post">
            <label for="account">Numéro de compte :</label>
            <input type="text" id="account" name="account" required>
            <button type="submit">Générer PDF</button>
        </form>
    </div>
</body>
</html>
