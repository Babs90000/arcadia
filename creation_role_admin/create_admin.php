<?php
// Connexion à la base de données
try {
    $base_de_donnees = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
    $base_de_donnees->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    // Hacher le mot de passe
    $password_hache = password_hash($password, PASSWORD_BCRYPT);

    // Insérer l'utilisateur administrateur avec le mot de passe haché
    $sql = "INSERT INTO utilisateurs (username, role_id, password, nom, prenom) VALUES (:username, :role_id, :password, :nom, :prenom)";
    $statement = $base_de_donnees->prepare($sql);
    $statement->execute([
        ':username' => $username,
        ':role_id' => 1, // 1 pour le rôle d'administrateur
        ':password' => $password_hache,
        ':nom' => $nom,
        ':prenom' => $prenom
    ]);

    echo "Utilisateur administrateur créé avec succès.";
}
?>