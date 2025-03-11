<?php
$server = "localhost";
$port = 3308; // Ajout du port 3308
$login = "root";
$pass = "";
$dbname = "banque";

try {
    // Connexion avec le port 3308
    $connexion = new PDO("mysql:host=$server;port=$port;dbname=$dbname;charset=utf8", $login, $pass);
    
    // Activer les erreurs PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage();
}
?>
