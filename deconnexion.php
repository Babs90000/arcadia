<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php"); // Redirige vers la page d'accueil après la déconnexion
exit();
?>