<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remboursement Partiel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
        }
        .btn-return {
            background-color: #6c757d;
            color: white;
        }
        .btn-return:hover {
            background-color: #5a6268;
            color: white;
        }
        .form-control:focus {
            border-color: #495057;
            box-shadow: 0 0 0 0.25rem rgba(73, 80, 87, 0.25);
        }
    </style>
</head>
<body>
    <div class="alert-container">
        <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

        if (isset($_POST['submit4'])) {
            $num_rendu = $_POST['num_rendu'];
            $num_pret = $_POST['num_pret'];
            $date_rendu = $_POST['date_rendu'];
            $montant_rendu = $_POST['montant_rendu'];

            try {
                if (empty($num_rendu) || empty($num_pret) || empty($date_rendu) || empty($montant_rendu)) {
                    throw new Exception("Tous les champs doivent être remplis !");
                }

                $connexion->beginTransaction();

                // Récupérer le montant du prêt et le bénéfice
                $query = $connexion->prepare("SELECT montant_prete, beneficeBanque, numCompte FROM preter WHERE num_pret = :num_pret");
                $query->bindParam(":num_pret", $num_pret, PDO::PARAM_INT);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);

                if (!$result) {
                    throw new Exception("Le prêt n'existe pas !");
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
                $situation = "payé une part";
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

                $connexion->commit();

                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Succès !</strong> Remboursement partiel effectué. Montant remboursé : '.$montant_rendu.' €.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            } catch (Exception $e) {
                $connexion->rollBack();
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Erreur !</strong> '.$e->getMessage().'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        }
        ?>
    </div>

    <div class="container mt-5">
        <div class="form-container">
            <div class="card shadow">
                <div class="card-header text-center py-3">
                    <h2 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Remboursement Partiel</h2>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="num_rendu" class="form-label">Numéro de remboursement</label>
                            <input type="number" class="form-control" id="num_rendu" name="num_rendu" required>
                        </div>

                        <div class="mb-3">
                            <label for="num_pret" class="form-label">Numéro du prêt</label>
                            <input type="number" class="form-control" id="num_pret" name="num_pret" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_rendu" class="form-label">Date de remboursement</label>
                            <input type="date" class="form-control" id="date_rendu" name="date_rendu" required>
                        </div>

                        <div class="mb-3">
                            <label for="montant_rendu" class="form-label">Montant à rembourser (€)</label>
                            <input type="number" step="0.01" class="form-control" id="montant_rendu" name="montant_rendu" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark" name="submit4">
                                <i class="fas fa-hand-holding-usd me-2"></i>Effectuer le remboursement
                            </button>
                            <a href="javascript:history.back()" class="btn btn-return">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fermer automatiquement les alertes après 5 secondes
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>