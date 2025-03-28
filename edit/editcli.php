<?php
// Connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');

// Récupérer l'ID du client (numCompte) passé en paramètre de l'URL
$numCompte = $_GET['numCompte'] ?? null;

if ($numCompte) {
    // Récupérer les informations du client depuis la base de données
    $query = $connexion->prepare("SELECT * FROM CLIENT WHERE numCompte=:numCompte");
    $query->bindParam(':numCompte', $numCompte);
    $query->execute();
    $client = $query->fetch();

    // Remplir les variables avec les données du client
    if ($client) {
        $numCompte = $client['numCompte'];
        $nom = $client['Nom'];
        $prenoms = $client['Prenoms'];
        $tel = $client['Tel'];
        $mail = $client['mail'];
        $solde = $client['Solde'];
    }
}
?>

<!-- Modal Edit Client -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modifier les informations du client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <!-- Champ Numéro de compte -->
                    <label for="num_compte">Numéro compte:</label>
                    <input type="text" id="num_compte" name="numCompte" class="form-control" value="<?php echo $numCompte; ?>" readonly>

                    <!-- Champ Nom -->
                    <label for="username">Nom:</label>
                    <input type="text" id="username" name="Nom" class="form-control" value="<?php echo htmlspecialchars($nom); ?>" required>

                    <!-- Champ Prénoms -->
                    <label for="firstname">Prénoms:</label>
                    <input type="text" id="firstname" name="Prenoms" class="form-control" value="<?php echo htmlspecialchars($prenoms); ?>" required>

                    <!-- Champ Téléphone -->
                    <label for="mobile">Téléphone:</label>
                    <input type="text" id="mobile" name="Tel" class="form-control" value="<?php echo htmlspecialchars($tel); ?>" required>

                    <!-- Champ Email -->
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="mail" class="form-control" value="<?php echo htmlspecialchars($mail); ?>" required>

                    <!-- Champ Solde -->
                    <label for="solde">Solde:</label>
                    <input type="text" id="solde" name="Solde" class="form-control" value="<?php echo htmlspecialchars($solde); ?>" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-dark" name="updateClient">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Traitement de la mise à jour du client
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateClient'])) {
    // Récupération des données soumises
    $numCompte = $_POST['numCompte'];
    $nom = $_POST['Nom'];
    $prenoms = $_POST['Prenoms'];
    $tel = $_POST['Tel'];
    $mail = $_POST['mail'];
    $solde = $_POST['Solde'];

    // Mise à jour des informations du client dans la base de données
    if ($numCompte) {
        $sql = "UPDATE CLIENT SET Nom = :nom, Prenoms = :prenoms, Tel = :tel, mail = :mail, Solde = :solde WHERE numCompte = :numCompte";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenoms', $prenoms);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':solde', $solde);
        $stmt->bindParam(':numCompte', $numCompte);

        // Exécution de la requête
        if ($stmt->execute()) {
            echo "<script>alert('Les informations du client ont été mises à jour avec succès.');</script>";
        } else {
            echo "<script>alert('Erreur lors de la mise à jour des informations.');</script>";
        }
    }
}
?>
