<?php
session_start();
//entrer des identifiants pour se connecter
if (isset($_POST['Se_connecter'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];

        //connexion à la base de données et verification présence utilisateur
        $bdd = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
        $statement = $bdd->prepare('SELECT* FROM utilisateurs WHERE username = :username');
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);


        if (($user && password_verify($password, $user['password'])) === true) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['role'] = $user['role_id'];
            $_SESSION['message_connexion'] = 'Bonjour ' . $user['prenom'] . ' ' . $user['nom'] . ' Vous êtes connecté ! ';

            if ($_SESSION['role'] == 1) {
                header('Location: ./pages/espace_admin.php');
            } elseif ($_SESSION['role'] == 2) {
                header('Location: ./espace_employe.php');
            } else {
                header('Location: ./espace_veterinaire.php');
            }
        } else {
            echo 'Identifiants incorrects';
        }
    } else {
        echo 'Veuillez compléter tous les champs';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
</head>

<body>
    <h2>Connexion</h2>
    <form action="" method="post">
        <label for="username">Nom d'utilisateur (e-mail) :</label><br>
        <input type="email" id="username" name="username" required autocomplete="off"><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required autocomplete="off"><br><br>

        <input type="submit" name="Se_connecter" value="Se connecter">
    </form>
</body>

</html>