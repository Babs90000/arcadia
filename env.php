<?php
// Vérifiez si les variables de connexion sont définies via une URL de base de données
if (isset($_ENV['JAWSDB_URL'])) {
    $dbparts = parse_url($_ENV['JAWSDB_URL']);
    $hostname = $dbparts['host'];
    $username = $dbparts['user'];
    $password = $dbparts['pass'];
    $database = ltrim($dbparts['path'], '/');
} else {
    // Sinon, utilisez les valeurs par défaut
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'arcadia';
}

try {
    // Initialisez la connexion PDO
    $bdd = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affichez un message d'erreur en cas d'échec de la connexion
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit();
}
?>
