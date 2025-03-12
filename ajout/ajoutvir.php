<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virement Bancaire</title>
    <link rel="stylesheet" href="../css/ajoutvir.css">
</head>
<body>
    <div class="container">
        <h2>Virement Bancaire</h2>
        <form method="POST">
            <label for="compte_source">Compte Expéditeur :</label>
            <input type="text" name="numCompteEnvoyeur" required>

            <label for="compte_dest">Compte Bénéficiaire :</label>
            <input type="text" name="numCompteBeneficiaire" required>

            <label for="montant">Montant (€) :</label>
            <input type="number" name="montant" step="0.01" required>

            <label for="date Transfert">Date Transfert:</label>
            <input type="date" name="date_Transfert" required>

            <button type="submit" name="submit">Effectuer le Virement</button>
        </form>
    </div>
</body>
</html>

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
        die("❌ Erreur : Veuillez remplir tous les champs.");
    }

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
        echo "✅ Le virement a été effectué avec succès.";
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollBack();
        echo "❌ Erreur : " . $e->getMessage();
    }
}
?>
