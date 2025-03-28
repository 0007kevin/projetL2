<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projetL2/database/connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Inclure PHPMailer via Composer

function envoyerEmail($expediteur, $destinataire, $sujet, $messageHTML) {
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'andrianilanathierry@gmail.com'; 
        $mail->Password = 'amplzyoforudiywy'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Paramètres de l’e-mail
        $mail->setFrom($expediteur, 'MyBanque'); // Expéditeur dynamique
        $mail->addAddress($destinataire); // Destinataire dynamique
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body = $messageHTML;

        return $mail->send();
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erreur lors de l'envoi de l'e-mail : " . $mail->ErrorInfo . "</div>";
        return false;
    }
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['envoyer_email'])) {
    $numCompte = trim($_POST['numCompte']);
    $expediteur = trim($_POST['expediteur']); // Récupération de l'expéditeur depuis le formulaire

    // Vérification des entrées utilisateur
    if (!filter_var($expediteur, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Adresse e-mail de l'expéditeur invalide.</div>";
        exit;
    }

    if (!preg_match('/^\d+$/', $numCompte)) { 
        echo "<div class='alert alert-danger'>Numéro de compte invalide.</div>";
        exit;
    }

    // Récupérer les informations du client et la date de fin de prêt
    $stmt = $connexion->prepare("SELECT c.Nom, c.Prenoms, c.mail, p.num_pret, 
                                    COALESCE(r.rest_paye, 0) AS rest_paye, 
                                    (p.montant_prete - COALESCE(r.rest_paye, 0)) AS montant_rendu, 
                                    p.date_fin
                                FROM client c 
                                JOIN preter p ON c.numCompte = p.numCompte
                                LEFT JOIN rendre r ON p.num_pret = r.num_pret
                                WHERE c.numCompte = :numCompte");

    $stmt->bindParam(':numCompte', $numCompte);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $client = $stmt->fetch();
        $emailDestinataire = $client['mail']; // Destinataire dynamique
        $nom = $client['Nom'];
        $prenom = $client['Prenoms'];
        $num_pret = $client['num_pret'];
        $montant_rendu = $client['montant_rendu'];
        $rest_paye = $client['rest_paye'];
        $date_fin = $client['date_fin'];

        // Vérifier si la date de fin existe et calculer les jours restants
        if ($date_fin) {
            // Créer un objet DateTime pour la date de fin et pour aujourd'hui
            $date_fin = new DateTime($date_fin);
            $date_aujourdhui = new DateTime();

            // Calculer l'intervalle entre les deux dates
            $interval = $date_aujourdhui->diff($date_fin);
            $jours_restants = $interval->days;

            // Si la date actuelle est après la date de fin, il n'y a plus de jours restants
            if ($date_aujourdhui > $date_fin) {
                $jours_restants = 0;
            }

            // Vérifier si la date de fin est dans les 30 jours
            $date_plus_30_jours = (new DateTime())->add(new DateInterval('P30D'));
            $date_fin_est_proche = ($date_fin <= $date_plus_30_jours);

        } else {
            $jours_restants = null; // Pas de date de fin disponible
            $date_fin_est_proche = false;
        }

        if ($rest_paye > 0) {
            // Contenu de l'email
            $sujet = "Notification de Paiement Partiel";
            $messageHTML = "
                <h2>Rappel de Paiement</h2>
                <p>Bonjour <strong>$prenom $nom</strong>,</p>
                <p>Nous vous informons qu'il vous reste encore <strong>$rest_paye Ar</strong> à payer.</p>
                ";

            // Ajouter les jours restants si disponibles
            if ($jours_restants !== null) {
                $messageHTML .= "<li><strong>Jours Restants :</strong> $jours_restants jours</li>";
            } else {
                $messageHTML .= "<li><strong>Jours Restants :</strong> Non disponibles</li>";
            }

            // Si la date de fin est dans les 30 jours, ajouter un message d'alerte
            if ($date_fin_est_proche) {
                $messageHTML .= "<li><strong>Attention :</strong> Votre date limite de paiement est dans moins de 30 jours.</li>";
            }

            $messageHTML .= "</ul>
                <p>Merci de régulariser votre situation dès que possible.</p>";

            // Debug: Afficher la valeur des jours restants pour vérifier
            // var_dump($jours_restants); // Décommenter pour déboguer

            // Envoi de l'e-mail avec expéditeur et destinataire dynamiques
            if (envoyerEmail($expediteur, $emailDestinataire, $sujet, $messageHTML)) {
                echo "<div class='alert alert-info'>L'e-mail de notification a été envoyé avec succès.</div>";
            } else {
                echo "<div class='alert alert-danger'>Erreur lors de l'envoi de l'e-mail.</div>";
            }
        } else {
            echo "<div class='alert alert-success'>Ce client a déjà tout payé. Aucun e-mail envoyé.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Aucun client trouvé avec ce numéro de compte.</div>";
    }
}
?>

<!-- Formulaire HTML pour entrer le numéro de compte et l'expéditeur -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification de Paiement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Envoyer une Notification de Paiement</h2>

    <form method="post">
        <div class="mb-3">
            <label for="expediteur" class="form-label">Adresse e-mail de l'expéditeur :</label>
            <input type="email" class="form-control" id="expediteur" name="expediteur" required>
        </div>
        <div class="mb-3">
            <label for="numCompte" class="form-label">Numéro de Compte :</label>
            <input type="text" class="form-control" id="numCompte" name="numCompte" required>
        </div>
        <button type="submit" class="btn btn-primary" name="envoyer_email">Envoyer l'Email</button>
    </form>
</body>
</html>
