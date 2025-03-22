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
                <label for="montant" class="form-label">Montant</label>
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
        if (empty($num_rendu) || empty($num_pret) || empty($date_rendu) || empty($montant_rendu)) {
            throw new Exception("❌ Erreur : Tous les champs doivent être remplis !");
        }

        $connexion->beginTransaction();

        // Récupérer le montant du prêt et le bénéfice
        $query = $connexion->prepare("SELECT montant_prete, beneficeBanque, numCompte FROM preter WHERE num_pret = :num_pret");
        $query->bindParam(":num_pret", $num_pret, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception("❌ Erreur : Le prêt n'existe pas !");
        }

        $montant_prete = $result['montant_prete'];
        $beneficeBanque = $result['beneficeBanque'];
        $numCompte = $result['numCompte'];
        $montant_total_a_rembourser = $montant_prete + $beneficeBanque;
        $rest_paye = $montant_total_a_rembourser - $montant_rendu;

        // Insérer dans la table RENDRE
        $sql = "INSERT INTO RENDRE (num_rendu, num_pret, date_rendu, rest_paye, situation, montant_rendu) 
                VALUES (:num_rendu, :num_pret, :date_rendu, :rest_paye, :situation, :montant_rendu)";
        $requete = $connexion->prepare($sql);
        $requete->bindParam(":num_rendu", $num_rendu, PDO::PARAM_INT);
        $requete->bindParam(":num_pret", $num_pret, PDO::PARAM_INT);
        $requete->bindParam(":date_rendu", $date_rendu);
        $requete->bindParam(":rest_paye", $rest_paye, PDO::PARAM_INT);
        $requete->bindParam(":montant_rendu", $montant_rendu, PDO::PARAM_INT);
        $situation = "payé une part"; // Ajout ici
        $requete->bindParam(":situation", $situation, PDO::PARAM_STR);
        $requete->execute();

        // Mettre à jour la table `preter`
        $update = $connexion->prepare("UPDATE preter SET montant_prete = montant_prete - :montant_rendu 
                                       WHERE num_pret = :num_pret");
        $update->bindParam(":montant_rendu", $montant_rendu, PDO::PARAM_INT);
        $update->bindParam(":num_pret", $num_pret, PDO::PARAM_INT);
        $update->execute();

        // Mettre à jour le solde du client
        $updateSolde = $connexion->prepare("UPDATE client SET solde = solde - :montant_rendu WHERE numCompte = :numCompte");
        $updateSolde->bindParam(":montant_rendu", $montant_rendu, PDO::PARAM_INT);
        $updateSolde->bindParam(":numCompte", $numCompte, PDO::PARAM_INT);
        $updateSolde->execute();

        // Vérifier si une ligne existe déjà dans RENDRE
        $check = $connexion->prepare("SELECT COUNT(*) FROM RENDRE WHERE num_pret = :num_pret");
        $check->bindParam(":num_pret", $num_pret, PDO::PARAM_INT); 
        $check->execute();
        $exists = $check->fetchColumn();

       

        $connexion->commit();

        echo "✅ Remboursement effectué avec succès. Montant total remboursé : $montant_rendu €.";

    } catch (Exception $e) {
        $connexion->rollBack();
        echo "❌ Erreur : " . $e->getMessage();
    }
}

?>
