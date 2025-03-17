<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendre de l'Argent</title>
    <link rel="stylesheet" href="/projetL2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="bg-dark text-light text-center py-2">Rendre de l'Argent à la Banque</h2>

        <form action="" method="POST" class="border p-4 shadow rounded">
            <div class="mb-3">
                <label for="num_rendu" class="form-label">Numéro de Rendu</label>
                <input type="number" class="form-control" id="num_rendu" name="num_rendu" required>
            </div>

            <div class="mb-3">
                <label for="num_pret" class="form-label">Numéro du Prêt</label>
                <input type="number" class="form-control" id="num_pret" name="num_pret" required>
            </div>

            <div class="mb-3">
                <label for="date_rendu" class="form-label">Date de Rendu</label>
                <input type="date" class="form-control" id="date_rendu" name="date_rendu" required>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">montant</label>
                <input type="number" class="form-control" id="montant_rendu" name="montant_rendu" required>
            </div>

            <button type="submit" class="btn btn-dark w-100" name="submit4">Enregistrer le Rendu</button>
        </form>
    </div>

    <script src="/projetL2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

if (isset($_POST['submit4'])) {
    $num_rendu = $_POST['num_rendu'];
    $num_pret = $_POST['num_pret'];
    $date_rendu = $_POST['date_rendu'];
    $montant_rendu = $_POST['montant_rendu'];
    try {
        // Démarrer une transaction
        $connexion->beginTransaction();

        // Insérer dans la table RENDRE
        $sql = "INSERT INTO RENDRE (num_rendu, num_pret, date_rendu, rest_payé, situation,montant_rendu) 
                VALUES (:num_rendu, :num_pret, :date_rendu,:rest_payé, 'payé une part',:montant_rendu)";
        $requete = $connexion->prepare($sql);
        $requete->bindParam(":num_rendu", $num_rendu);
        $requete->bindParam(":num_pret", $num_pret);
        $requete->bindParam(":date_rendu", $date_rendu);
        $requete->bindParam(":montant_rendu", $montant_rendu);
        $requete->execute();

        // Récupérer le montant du prêt et le bénéfice de la banque
        $query = $connexion->prepare("SELECT montant_prete, beneficeBanque FROM preter WHERE num_pret = :num_pret");
        $query->bindParam(":num_pret", $num_pret);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception("❌ Erreur : Le prêt n'existe pas !");
        }

        $montant_prete = $result['montant_prete'];
        $beneficeBanque = $result['beneficeBanque'];
        $montant_rendu = $montant_prete + $beneficeBanque; // Le total à rembourser

        // Mettre à jour la table `preter` (montant_prêté = 0)
        $update = $connexion->prepare("UPDATE preter SET montant_prete = montant_prete-montant_rendu WHERE num_pret = :num_pret");
        $update->bindParam(":num_pret", $num_pret);
        $update->execute();

        // Mettre à jour le solde du client (déduire le montant rendu)
        $updateSolde = $connexion->prepare("UPDATE client SET solde = solde - :montant_rendu 
                                            WHERE numCompte = (SELECT numCompte FROM preter WHERE num_pret = :num_pret)");
        $updateSolde->bindParam(":montant_rendu", $montant_rendu);
        $updateSolde->bindParam(":num_pret", $num_pret);
        $updateSolde->execute();
         $rendu="UPDATE RENDRE SET montant_rendu=:montant_rendu WHERE num_pret=:num_pret";
         $update2 = $connexion->prepare($rendu);
         $update2->bindParam(":montant_rendu", $montant_rendu);
         $update2->bindParam(":num_pret", $num_pret);
         $update2->execute();

        // Confirmer la transaction
        $connexion->commit();

        echo "✅ Remboursement effectué avec succès. Montant total remboursé : $montant_rendu €.";

    } catch (Exception $e) {
        $connexion->rollBack();
        echo "❌ Erreur : " . $e->getMessage();
    }
}

  
?>

