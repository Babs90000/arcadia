<?php

require_once '../template/header.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 1) {

    header('Location: connexion_utilisateur.php');
    exit();
}


$role_utilisateur = $_SESSION['role'];
$prenom = $_SESSION['prenom'];
$role_label = '';
switch ($role_utilisateur) {
    case 1:
        $role_label = 'Administrateur';
        break;
    case 2:
        $role_label = 'Employé';
        break;
    case 3:
        $role_label = 'Vétérinaire';
        break;
    default:
        $role_label = 'Utilisateur';
        break;
}
$base_url = 'http://' . $_SERVER['arcadia-project-155bc9d56c41.herokuapp.com/'] . '/arcadia/';
?>
<link rel=stylesheet href="./style_espace_utilisateur.css">
<main>
    <div class="container">
        <h1>Bienvenue dans l'Espace Admin</h1>
        <p>Bonjour <?php echo $prenom; ?>, vous êtes connecté !</p>
        <a href="<?php echo $base_url; ?>fonctionnalités/gestion_service.php">Gestion des services</a><br>
        <a href="<?php echo $base_url; ?>fonctionnalités/inscription_utilisateur.php">Gestion des utilisateurs</a><br>
        <a href="<?php echo $base_url; ?>fonctionnalités/gestion_animaux.php">Gestion des animaux</a><br>
        <a href="<?php echo $base_url; ?>pages/gestion_habitat.php">Gestion des habitats</a><br>
        <a href="<?php echo $base_url; ?>fonctionnalités/modification_horaire.php">Modification des horaires</a><br>
        <a href="<?php echo $base_url; ?>pages/rapports_veterinaires.php">Rapports vétérinaires</a><br>
        <a href="<?php echo $base_url; ?>fonctionnalités/valider_avis.php">Valider un avis</a><br>

    </div>
</main>


</body>

</html>
